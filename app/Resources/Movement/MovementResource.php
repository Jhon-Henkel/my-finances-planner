<?php

namespace App\Resources\Movement;

use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Resources\BasicResource;
use App\VO\Movement\MovementVO;

/**
 * @method MovementVO[] arrayDtoToVoItens(null|array $itens)
 * @method MovementDTO[] arrayToDtoItens(null|array $itens)
 */
class MovementResource extends BasicResource
{
    public function arrayToDto(array $item): MovementDTO
    {
        $dto = new MovementDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setWalletId($item['walletId'] ?? $item['wallet_id']);
        $dto->setWalletName($item['name'] ?? null);
        $dto->setDescription($item['description']);
        $dto->setType($item['type']);
        $dto->setAmount($item['amount']);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    public function dtoToArray($item): array
    {
        return array(
            'wallet_id' => $item->getWalletId(),
            'description' => $item->getDescription(),
            'type' => $item->getType(),
            'amount' => $item->getAmount()
        );
    }

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
        $type = $value > 0 ? MovementEnum::Gain->value : MovementEnum::Spent->value;
        $movement = new MovementDTO();
        $movement->setDescription('Atualização de carteira');
        $movement->setWalletId($walletId);
        $movement->setType($type);
        $movement->setAmount(round($value, 2));
        return $movement;
    }
}
