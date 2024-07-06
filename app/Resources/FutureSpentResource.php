<?php

namespace App\Resources;

use App\DTO\FutureMovement\FutureSpentDTO;
use App\DTO\InvoiceItemDTO;
use App\VO\FutureSpentVO;

class FutureSpentResource extends BasicResource
{
    public function arrayToDto(array $item): FutureSpentDTO
    {
        $dto = new FutureSpentDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setWalletName($item['name'] ?? null);
        $dto->setWalletId($item['wallet_id'] ?? $item['walletId']);
        $dto->setForecast($item['forecast']);
        $dto->setDescription($item['description']);
        $dto->setAmount($item['amount']);
        $dto->setInstallments($item['installments']);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @param FutureSpentDTO $item */
    public function dtoToArray($item): array
    {
        return [
            'id' => $item->getId(),
            'wallet_id' => $item->getWalletId(),
            'description' => $item->getDescription(),
            'forecast' => $item->getForecast(),
            'amount' => $item->getAmount(),
            'installments' => $item->getInstallments(),
            'created_at' => $item->getCreatedAt(),
            'updated_at' => $item->getUpdatedAt(),
        ];
    }

    /** @param FutureSpentDTO $item */
    public function dtoToVo($item): FutureSpentVO
    {
        return new FutureSpentVO($item);
    }

    public function futureSpentToInvoiceDTO(FutureSpentDTO $item): InvoiceItemDTO
    {
        return new InvoiceItemDTO(
            $item->getId(),
            $item->getWalletId(),
            $item->getWalletName(),
            $item->getDescription(),
            $item->getAmount(),
            $item->getForecast(),
            $item->getInstallments()
        );
    }
}
