<?php

namespace App\Resources;

use App\DTO\WalletDTO;
use App\Enums\BasicFieldsEnum;
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
        $dto->setId(isset($item[BasicFieldsEnum::ID]) ? (int)$item[BasicFieldsEnum::ID] : null);
        $dto->setName($item[BasicFieldsEnum::NAME]);
        $dto->setType((int)$item[BasicFieldsEnum::TYPE]);
        $dto->setAmount((float)$item[BasicFieldsEnum::AMOUNT]);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    /** @var WalletDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            BasicFieldsEnum::ID => $item->getId() ?? null,
            BasicFieldsEnum::NAME => $item->getName(),
            BasicFieldsEnum::TYPE => $item->getType(),
            BasicFieldsEnum::AMOUNT => $item->getAmount()
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