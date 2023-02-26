<?php

namespace App\Http\Resources;

use App\DTO\WalletDTO;

class WalletResource extends BasicResource
{
    public function arrayToDto(array $item): WalletDTO
    {
        $dto = new WalletDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setName($item['name']);
        $dto->setType($item['type']);
        $dto->setAmount($item['amount']);
        $dto->setCreatedAt($item['crested_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @var WalletDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            'name' => $item->getName(),
            'type' => $item->getType(),
            'amount' => $item->getAmount()
        );
    }
}
