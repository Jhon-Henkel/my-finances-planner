<?php

namespace App\Resources;

use App\DTO\MovementDTO;
use App\VO\MovementVO;

class MovementResource extends BasicResource
{

    public function arrayToDto(array $item): MovementDTO
    {
        $dto = new MovementDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setWalletId($item['walletId'] ?? $item['wallet_id']);
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

    /**
     * todo mover para o basic
     * @param null|array $itens
     * @return MovementDTO[]
     */
    public function arrayToDtoItens(null|array $itens): array
    {
        if (!$itens) {
            return array();
        }
        $itensResourced = array();
        foreach ($itens as $item) {
            $itensResourced[] = $this->arrayToDto($item);
        }
        return $itensResourced;
    }

    /**
     * todo mover para o basic
     * @param null|array $itens
     * @return MovementDTO[]
     */
    public function arrayDtoToVoItens(null|array $itens): array
    {
        if (!$itens) {
            return array();
        }
        $itensResourced = array();
        foreach ($itens as $item) {
            $itensResourced[] = $this->dtoToVo($item);
        }
        return $itensResourced;
    }
}