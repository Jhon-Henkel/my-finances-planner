<?php

namespace App\Modules\Wallet\Resource;

use App\Enums\StatusEnum;
use App\Modules\Wallet\DTO\WalletDTO;
use App\Modules\Wallet\Enum\WalletTypeEnum;
use App\Modules\Wallet\VO\WalletVO;
use App\Resources\BasicResource;

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
        $dto->setHideValue(isset($item['hide_value']) ? (int)$item['hide_value'] : StatusEnum::Inactive->value);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    public function dtoToArray($item): array
    {
        return array(
            'id' => $item->getId() ?? null,
            'name' => $item->getName(),
            'type' => $item->getType(),
            'amount' => $item->getAmount(),
            'hide_value' => $item->getHideValue(),
        );
    }

    /**
     * @param WalletDTO $item
     * @return WalletVO
     */
    public function dtoToVo($item): WalletVO
    {
        return WalletVO::makeWalletVO(
            $item->getId(),
            $item->getName(),
            $item->getType(),
            $item->getAmount(),
            $item->getHideValue(),
            $item->getCreatedAt(),
            $item->getUpdatedAt()
        );
    }
}
