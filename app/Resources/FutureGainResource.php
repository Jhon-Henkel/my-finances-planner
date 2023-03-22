<?php

namespace App\Resources;

use App\DTO\FutureGainDTO;

class FutureGainResource extends BasicResource
{
    public function arrayToDto(array $item): FutureGainDTO
    {
        $dto = new FutureGainDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setWalletId($item['wallet_id'] ?? $item['walletId']);
        $dto->setDescription($item['description']);
        $dto->setForecast($item['forecast']);
        $dto->setAmount($item['amount']);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdateddAt($item['updated_at'] ?? null);
        return $dto;
    }

    public function dtoToArray($item): array
    {
        dd($item);
        // TODO: Implement dtoToArray() method.
    }

    public function dtoToVo($item)
    {
        dd($item);
        // TODO: Implement dtoToVo() method.
    }
}