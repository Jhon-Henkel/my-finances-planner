<?php

namespace App\Resources\Tools;

use App\DTO\Tools\MonthlyClosingDTO;
use App\Resources\BasicResource;
use App\VO\Tools\MonthlyClosingVO;

class MonthlyClosingResource extends BasicResource
{
    public function arrayToDto(array $item): MonthlyClosingDTO
    {
        return new MonthlyClosingDTO(
            $item['id'] ?? null,
            $item['predicted_earnings'] ?? null,
            $item['predicted_expenses'] ?? null,
            $item['real_earnings'] ?? null,
            $item['real_expenses'] ?? null,
            $item['balance'] ?? null,
            $item['created_at'] ?? null,
            $item['updated_at'] ?? null,
            $item['tenant_id'] ?? null
        );
    }

    /** @param MonthlyClosingDTO $item */
    public function dtoToArray($item): array
    {
        return [
            'id' => $item->getId(),
            'predicted_earnings' => $item->getPredictedEarnings(),
            'predicted_expenses' => $item->getPredictedExpenses(),
            'real_earnings' => $item->getRealEarnings(),
            'real_expenses' => $item->getRealExpenses(),
            'balance' => $item->getBalance(),
            'created_at' => $item->getCreatedAt(),
            'updated_at' => $item->getUpdatedAt(),
            'tenant_id' => $item->getTenantId()
        ];
    }

    /** @param MonthlyClosingDTO $item */
    public function dtoToVo($item): MonthlyClosingVO
    {
        return new MonthlyClosingVO(
            $item->getId(),
            $item->getPredictedEarnings(),
            $item->getPredictedExpenses(),
            $item->getRealEarnings(),
            $item->getRealExpenses(),
            $item->getBalance(),
            $item->getCreatedAt(),
            $item->getUpdatedAt(),
            $item->getTenantId()
        );
    }
}