<?php

namespace App\Resources;

use App\DTO\WalletDTO;
use App\VO\WalletVO;

 /**
 * @method WalletVO[] arrayDtoToVoItens(null|array $itens)
 * @method WalletDTO[] arrayToDtoItens(null|array $itens)
 */
class WalletResource extends BasicResource
{
    public function arrayToDto(array $item): WalletDTO
    {
        $dto = new WalletDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setName($item['name']);
        $dto->setType($item['type']);
        $dto->setAmount($item['amount']);
        $dto->setCreatedAt($item['created_at'] ?? null);
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

    /** @var WalletDTO $item */
    public function dtoToVo($item): WalletVO
    {
        $vo = new WalletVO();
        $vo->id = $item->getId();
        $vo->name = $item->getName();
        $vo->type = $item->getType();
        $vo->amount = $item->getAmount();
        $vo->createdAt = $item->getCreatedAt();
        $vo->updatedAt = $item->getUpdatedAt();
        return $vo;
    }
}