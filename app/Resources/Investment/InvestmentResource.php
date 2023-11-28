<?php

namespace App\Resources\Investment;

use App\DTO\Investment\InvestmentDTO;
use App\Resources\BasicResource;
use App\VO\Investment\InvestmentVO;

class InvestmentResource extends BasicResource
{
    public function arrayToDto(array $item): InvestmentDTO
    {
        return new InvestmentDTO(
            $item['id'] ?? null,
            $item['credit_card_id'] ?? null,
            $item['description'],
            $item['type'],
            $item['amount'],
            $item['liquidity'],
            $item['profitability'],
            $item['created_at']?? null,
            $item['updated_at'] ?? null
        );
    }

    /** @var InvestmentDTO $item */
    public function dtoToArray($item): array
    {
        return [
            'credit_card_id' => $item->getCreditCardId(),
            'description' => $item->getDescription(),
            'type' => $item->getType(),
            'amount' => $item->getAmount(),
            'liquidity' => $item->getLiquidity(),
            'profitability' => $item->getProfitability(),
        ];
    }

    /** @var InvestmentDTO $item */
    public function dtoToVo($item): InvestmentVO
    {
        return new InvestmentVO($item);
    }
}