<?php

namespace App\Resources;

use App\DTO\WalletDTO;
use App\Enums\WalletTypeEnum;
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
        $dto->setId(isset($item['id']) ? (int)$item['id'] : null);
        $dto->setName($item['name']);
        $dto->setType(isset($item['type']) ? (int)$item['type'] : WalletTypeEnum::Other->value);
        $dto->setAmount((float)$item['amount']);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @var WalletDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            'id' => $item->getId() ?? null,
            'name' => $item->getName(),
            'type' => $item->getType(),
            'amount' => $item->getAmount()
        );
    }

    /** @var WalletDTO $item */
    public function dtoToVo($item): WalletVO
    {
        return WalletVO::makeWalletVO(
            $item->getId(),
            $item->getName(),
            $item->getType(),
            $item->getAmount(),
            $item->getCreatedAt(),
            $item->getUpdatedAt()
        );
    }
}
