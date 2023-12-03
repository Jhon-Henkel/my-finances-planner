<?php

namespace App\Resources;

use App\DTO\FutureSpentDTO;
use App\DTO\InvoiceItemDTO;
use App\Enums\BasicFieldsEnum;
use App\VO\FutureSpentVO;

class FutureSpentResource extends BasicResource
{
    public function arrayToDto(array $item): FutureSpentDTO
    {
        $dto = new FutureSpentDTO();
        $dto->setId($item[BasicFieldsEnum::ID] ?? null);
        $dto->setWalletName($item[BasicFieldsEnum::NAME] ?? null);
        $dto->setWalletId($item[BasicFieldsEnum::WALLET_ID_DB] ?? $item[BasicFieldsEnum::WALLET_ID_JSON]);
        $dto->setForecast($item[BasicFieldsEnum::FORECAST]);
        $dto->setDescription($item[BasicFieldsEnum::DESCRIPTION]);
        $dto->setAmount($item[BasicFieldsEnum::AMOUNT]);
        $dto->setInstallments($item[BasicFieldsEnum::INSTALLMENTS]);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    /**
     * @param FutureSpentDTO $item
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
     * @param FutureSpentDTO $item
     * @return FutureSpentVO
     */
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