<?php

namespace App\Services;

use App\DTO\MovementDTO;
use App\Tools\StringTools;

class FinancialHealthService
{
    public function findByFilter(int $filterOption): array
    {
        $movements = $this->getMovementsByPeriod($filterOption);
        return $this->categorizeMovements($movements);
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
            if (isset($data[$movement->getType()][$title])) {
                $data[$movement->getType()][$title] += $movement->getAmount();
                continue;
            }
            $data[$movement->getType()][$title] = $movement->getAmount();
        }
        return $data;
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
}