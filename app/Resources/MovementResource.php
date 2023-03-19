<?php

namespace App\Resources;

use App\DTO\MovementDTO;
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
        $dto->setId($item['id'] ?? null);
        $dto->setWalletId($item['walletId'] ?? $item['wallet_id']);
        if (isset($item['name'])){
            $dto->setWalletName($item['name']);
        }
        $dto->setDescription($item['description']);
        $dto->setType($item['type']);
        $dto->setAmount($item['amount']);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @var MovementDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            'wallet_id' => $item->getWalletId(),
            'description' => $item->getDescription(),
            'type' => $item->getType(),
            'amount' => $item->getAmount()
        );
    }

    /** @var MovementDTO $item */
    public function dtoToVo($item): MovementVO
    {
        $vo = new MovementVO();
        $vo->id = $item->getId();
        $vo->walletId = $item->getWalletId();
        $vo->description = $item->getDescription();
        $vo->type = $item->getType();
        $vo->amount = $item->getAmount();
        $vo->createdAt = $item->getCreatedAt();
        $vo->updatedAt = $item->getUpdatedAt();
        return $vo;
    }
}