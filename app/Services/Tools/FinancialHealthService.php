<?php

namespace App\Services\Tools;

use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Modules\AiInsights\UseCase\GetFinancialHealthAiInsightUseCase\GetFinancialHealthAiInsightInsightUseCase;
use App\Services\CreditCard\CreditCardMovementService;
use App\Services\Movement\MovementService;
use App\Tools\NumberTools;
use App\Tools\StringTools;

class FinancialHealthService
{
    public function __construct(
        private readonly CreditCardMovementService $creditCardMovementService,
        private readonly MovementService $movementService,
        private readonly GetFinancialHealthAiInsightInsightUseCase $financialHealthAiInsightUseCase
    ) {
    }

    public function findByFilter(array $filterOption): array
    {
        $movements = $this->getMovementsByPeriod($filterOption);
        $dontGroupCards = false;
        if (isset($filterOption['dontGroupCardExpenses']) && $filterOption['dontGroupCardExpenses'] === "true") {
            $dontGroupCards = true;
        }
        if ($dontGroupCards) {
            $creditCardMovements = $this->creditCardMovementService->findByPeriod($filterOption);
            $movements = array_merge($movements, $creditCardMovements);
        }
        $movementsCategorized = $this->categorizeMovements($movements, $dontGroupCards);
        return $this->addDataForGraph($movementsCategorized);
    }

    /** @return MovementDTO[] */
    protected function getMovementsByPeriod(array $filterOption): array
    {
        return $this->movementService->findByFilter($filterOption);
    }

    protected function categorizeMovements(array $movements, bool $dontGroupCards): array
    {
        $data = [];
        foreach ($movements as $movement) {
            $description = $movement->getDescription();
            $title = $this->getCategoryTitleByDescription($description);
            if ($dontGroupCards && $title === 'Cartão de crédito') {
                continue;
            }
            $amount = NumberTools::roundFloatAmount($movement->getAmount());
            if (isset($data[$movement->getType()][$title])) {
                $data[$movement->getType()][$title] += $amount;
                continue;
            }
            $data[$movement->getType()][$title] = $amount;
        }
        return $this->sortByValue($data);
    }

    protected function getCategoryTitleByDescription(string $description): string
    {
        if (str_contains($description, 'Fatura cartão')) {
            return 'Cartão de crédito';
        }
        $reservedWords = ['recebimento', 'parcial', 'pagamento', 'restante'];
        $descriptionLower = strtolower($description);
        $descriptionWithoutMonth = StringTools::removeMonthNameFromString($descriptionLower);
        $descriptionWithoutReservedWords = str_replace($reservedWords, '', $descriptionWithoutMonth);
        $descriptionWithoutExtraSpaces = StringTools::removeExtraSpacesFromString($descriptionWithoutReservedWords);
        return ucfirst($descriptionWithoutExtraSpaces);
    }

    protected function sortByValue(array $data): array
    {
        foreach ($data as $type => $movements) {
            arsort($data[$type]);
        }
        return $data;
    }

    protected function addDataForGraph(array $movements): array
    {
        $spending = ['label' => [], 'data' => [], 'color' => [], 'total' => 0];
        $gains = ['label' => [], 'data' => [], 'color' => [], 'total' => 0];
        if (isset($movements[MovementEnum::Gain->value])) {
            foreach ($movements[MovementEnum::Gain->value] as $title => $amount) {
                $gains['label'][] = $title;
                $gains['data'][] = $amount;
                $gains['color'][] = StringTools::generateRandomHexColor();
                $gains['total'] += $amount;
            }
        }
        if (isset($movements[MovementEnum::Spent->value])) {
            foreach ($movements[MovementEnum::Spent->value] as $title => $amount) {
                $spending['label'][] = $title;
                $spending['data'][] = $amount;
                $spending['color'][] = StringTools::generateRandomHexColor();
                $spending['total'] += $amount;
            }
        }
        $movements['dataForGraph'] = [MovementEnum::Spent->value => $spending, MovementEnum::Gain->value => $gains];
        $movements['ai_insight'] = $this->financialHealthAiInsightUseCase->execute($movements);
        return $movements;
    }
}
