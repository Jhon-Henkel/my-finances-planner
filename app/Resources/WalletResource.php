<?php

namespace App\Resources;

use App\DTO\WalletDTO;
use App\VO\WalletVO;

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

    /**
     * todo mover para o basic
     * @param null|array $itens
     * @return WalletDTO[]
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
     * @return WalletVO[]
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