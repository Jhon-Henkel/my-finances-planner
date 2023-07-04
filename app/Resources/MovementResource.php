<?php

namespace App\Resources;

use App\DTO\MovementDTO;
use App\Enums\BasicFieldsEnum;
use App\Enums\MovementEnum;
use App\VO\MovementVO;

 /**
 * @method MovementVO[] arrayDtoToVoItens(null|array $itens)
 * @method MovementDTO[] arrayToDtoItens(null|array $itens)
 */
class MovementResource extends BasicResource
{

    public function arrayToDto(array $item): MovementDTO
    {
        $dto = new MovementDTO();
        $dto->setId($item[BasicFieldsEnum::ID] ?? null);
        $dto->setWalletId($item[BasicFieldsEnum::WALLET_ID_JSON] ?? $item[BasicFieldsEnum::WALLET_ID_DB]);
        $dto->setWalletName($item[BasicFieldsEnum::NAME] ?? null);
        $dto->setDescription($item[BasicFieldsEnum::DESCRIPTION]);
        $dto->setType($item[BasicFieldsEnum::TYPE]);
        $dto->setAmount($item[BasicFieldsEnum::AMOUNT]);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    /** @var MovementDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            BasicFieldsEnum::WALLET_ID_DB => $item->getWalletId(),
            BasicFieldsEnum::DESCRIPTION => $item->getDescription(),
            BasicFieldsEnum::TYPE => $item->getType(),
            BasicFieldsEnum::AMOUNT => $item->getAmount()
        );
    }

    /** @var MovementDTO $item */
    public function dtoToVo($item): MovementVO
    {
        $vo = new MovementVO();
        $vo->id = $item->getId();
        $vo->walletId = $item->getWalletId();
        $vo->walletName = $item->getWalletName();
        $vo->description = $item->getDescription();
        $vo->type = $item->getType();
        $vo->amount = $item->getAmount();
        $vo->createdAt = $item->getCreatedAt();
        $vo->updatedAt = $item->getUpdatedAt();
        return $vo;
    }

    public function populateMovementForWalletUpdate(float $value, int $walletId): MovementDTO
    {
        $type = $value > 0 ? MovementEnum::GAIN : MovementEnum::SPENT;
        $movement = new MovementDTO();
        $movement->setDescription('Atualização de carteira');
        $movement->setWalletId($walletId);
        $movement->setType($type);
        $movement->setAmount(round($value, 2));
        return $movement;
    }
}