<?php

namespace App\Modules\Old\Wallet\Resource;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Modules\Old\Wallet\DTO\WalletDTO;
use App\Modules\Old\Wallet\Enum\WalletTypeEnum;
use App\Modules\Old\Wallet\VO\WalletVO;
use App\Resources\BasicResource;

/**
* @method WalletVO[] arrayDtoToVoItens(null|array $itens)
* @method WalletDTO[] arrayToDtoItens(null|array $itens)
*/
class WalletResource extends BasicResource
{
    public function arrayToDto(array $item): WalletDTO
    {
        if (isset($item['hideValue'])) {
            $item['hide_value'] = $item['hideValue'];
        }
        if (isset($item['active'])) {
            $item['status'] = (int)$item['active'];
        }
        $dto = new WalletDTO();
        $dto->setId(isset($item['id']) ? (int)$item['id'] : null);
        $dto->setName($item['name']);
        $dto->setType(isset($item['type']) ? (int)$item['type'] : WalletTypeEnum::Other->value);
        $dto->setStatus($item['status']);
        $dto->setAmount((float)$item['amount']);
        $dto->setHideValue(isset($item['hide_value']) ? (int)$item['hide_value'] : StatusActiveInactiveEnum::Inactive->value);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @param WalletDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            'id' => $item->getId() ?? null,
            'name' => $item->getName(),
            'type' => $item->getType(),
            'amount' => $item->getAmount(),
            'hide_value' => $item->getHideValue(),
            'status' => $item->getStatus(),
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
            $item->mustHideValue(),
            $item->getStatus() === StatusActiveInactiveEnum::Active->value,
            $item->getCreatedAt(),
            $item->getUpdatedAt()
        );
    }
}
