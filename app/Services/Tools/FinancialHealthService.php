<?php

namespace App\Services\Tools;

use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Services\CreditCard\CreditCardMovementService;
use App\Services\Movement\MovementService;
use App\Tools\NumberTools;
use App\Tools\StringTools;

class FinancialHealthService
{
    private CreditCardMovementService $creditCardMovementService;

    public function __construct(CreditCardMovementService $creditCardMovementService)
    {
        $this->creditCardMovementService = $creditCardMovementService;
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

    /**
     * @param int $filterOption
     * @return MovementDTO[]
     */
    protected function getMovementsByPeriod(array $filterOption): array
    {
        $movementService = app(MovementService::class);
        return $movementService->findByFilter($filterOption);
    }

    /**
     * @param MovementDTO[] $movements
     * @return array
     */
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
        if (isset($movements[MovementEnum::GAIN])) {
            foreach ($movements[MovementEnum::GAIN] as $title => $amount) {
                $gains['label'][] = $title;
                $gains['data'][] = $amount;
                $gains['color'][] = StringTools::generateRandomHexColor();
                $gains['total'] += $amount;
            }
        }
        if (isset($movements[MovementEnum::SPENT])) {
            foreach ($movements[MovementEnum::SPENT] as $title => $amount) {
                $spending['label'][] = $title;
                $spending['data'][] = $amount;
                $spending['color'][] = StringTools::generateRandomHexColor();
                $spending['total'] += $amount;
            }
        }
        $movements['dataForGraph'] = [MovementEnum::SPENT => $spending, MovementEnum::GAIN => $gains];
        return $movements;
    }
}