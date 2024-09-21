<?php

namespace App\Resources\Plan;

use App\DTO\Plan\PlanDTO;
use App\Resources\BasicResource;
use App\VO\Plan\PlanVO;

class PlanResource extends BasicResource
{
    public function arrayToDto(array $item): PlanDTO
    {
        return new PlanDTO(
            $item['id'],
            $item['name'],
            $item['wallet_limit'],
            $item['credit_card_limit']
        );
    }

    /** @param PlanDTO $item */
    public function dtoToArray($item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'wallet_limit' => $item->getWalletLimit(),
            'credit_card_limit' => $item->getCreditCardLimit()
        ];
    }

    public function dtoToVo($item): PlanVO
    {
        return new PlanVO($item);
    }
}
