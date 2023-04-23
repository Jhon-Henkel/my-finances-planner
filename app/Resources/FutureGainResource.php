<?php

namespace App\Resources;

use App\DTO\FutureGainDTO;
use App\DTO\InvoiceItemDTO;
use App\Enums\BasicFieldsEnum;
use App\VO\FutureGainVO;

class FutureGainResource extends BasicResource
{
    public function arrayToDto(array $item): FutureGainDTO
    {
        $dto = new FutureGainDTO();
        $dto->setId($item[BasicFieldsEnum::ID] ?? null);
        $dto->setWalletId($item[BasicFieldsEnum::WALLET_ID_DB] ?? $item[BasicFieldsEnum::WALLET_ID_JSON]);
        $dto->setDescription($item[BasicFieldsEnum::DESCRIPTION]);
        $dto->setForecast($item[BasicFieldsEnum::FORECAST]);
        $dto->setAmount($item[BasicFieldsEnum::AMOUNT]);
        $dto->setInstallments($item[BasicFieldsEnum::INSTALLMENTS]);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    /**
     * @param FutureGainDTO $item
     * @return array
     */
    public function dtoToArray($item): array
    {
        return [
            BasicFieldsEnum::ID => $item->getId(),
            BasicFieldsEnum::WALLET_ID_DB => $item->getWalletId(),
            BasicFieldsEnum::DESCRIPTION => $item->getDescription(),
            BasicFieldsEnum::FORECAST => $item->getForecast(),
            BasicFieldsEnum::AMOUNT => $item->getAmount(),
            BasicFieldsEnum::INSTALLMENTS => $item->getInstallments(),
            BasicFieldsEnum::CREATED_AT => $item->getCreatedAt(),
            BasicFieldsEnum::UPDATED_AT => $item->getUpdatedAt(),
        ];
    }

    /**
     * @param FutureGainDTO $item
     * @return FutureGainVO
     */
    public function dtoToVo($item): FutureGainVO
    {
        return new FutureGainVO($item);
    }

    public function futureGainToInvoiceDTO(FutureGainDTO $item): InvoiceItemDTO
    {
        return new InvoiceItemDTO(
            $item->getId(),
            $item->getWalletId(),
            $item->getDescription(),
            $item->getAmount(),
            $item->getForecast(),
            $item->getInstallments()
        );
    }
}