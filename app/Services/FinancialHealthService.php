<?php

namespace App\Services;

use App\DTO\MovementDTO;
use App\Enums\MovementEnum;
use App\Tools\NumberTools;
use App\Tools\StringTools;

class FinancialHealthService
{
    public function findByFilter(int $filterOption): array
    {
        $movements = $this->getMovementsByPeriod($filterOption);
        $movementsCategorized = $this->categorizeMovements($movements);
        return $this->addDataForGraph($movementsCategorized);
    }

    /**
     * @param int $filterOption
     * @return MovementDTO[]
     */
    protected function getMovementsByPeriod(int $filterOption): array
    {
        $movementService = app(MovementService::class);
        return $movementService->findByFilter($filterOption);
    }

    /**
     * @param MovementDTO[] $movements
     * @return array
     */
    protected function categorizeMovements(array $movements): array
    {
        $data = [];
        foreach ($movements as $movement) {
            $description = $movement->getDescription();
            $title = $this->getCategoryTitleByDescription($description);
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