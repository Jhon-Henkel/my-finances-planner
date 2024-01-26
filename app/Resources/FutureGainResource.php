<?php

namespace App\Resources;

use App\DTO\FutureGainDTO;
use App\DTO\InvoiceItemDTO;
use App\VO\FutureGainVO;

class FutureGainResource extends BasicResource
{
    public function arrayToDto(array $item): FutureGainDTO
    {
        $dto = new FutureGainDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setWalletId($item['wallet_id'] ?? $item['walletId']);
        $dto->setWalletName($item['name'] ?? null);
        $dto->setDescription($item['description']);
        $dto->setForecast($item['forecast']);
        $dto->setAmount($item['amount']);
        $dto->setInstallments($item['installments']);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @param FutureGainDTO $item */
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

    /** @param FutureGainDTO $item */
    public function dtoToVo($item): FutureGainVO
    {
        return new FutureGainVO($item);
    }

    public function futureGainToInvoiceDTO(FutureGainDTO $item): InvoiceItemDTO
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