<?php

namespace App\Resources;

use App\DTO\CreditCardDTO;
use App\DTO\InvoiceItemDTO;
use App\Enums\BasicFieldsEnum;
use App\VO\CreditCardVO;

class CreditCardResource extends BasicResource
{
    public function arrayToDto(array $item): CreditCardDTO
    {
        $dto = new CreditCardDTO();
        $dto->setId($item[BasicFieldsEnum::ID] ?? null);
        $dto->setName($item[BasicFieldsEnum::NAME]);
        $dto->setLimit($item[BasicFieldsEnum::LIMIT]);
        $dto->setDueDate($item[BasicFieldsEnum::DUE_DATE_DB] ?? $item[BasicFieldsEnum::DUE_DATE_JSON]);
        $dto->setClosingDay($item[BasicFieldsEnum::CLOSING_DAY_DB] ?? $item[BasicFieldsEnum::CLOSING_DAY_JSON]);
        $dto->setNextInvoiceValue(null);
        $dto->setTotalValueSpending(null);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    public function dtoToArray($item): array
    {
        return [
            BasicFieldsEnum::NAME => $item->getName(),
            BasicFieldsEnum::LIMIT => $item->getLimit(),
            BasicFieldsEnum::DUE_DATE_DB => $item->getDueDate(),
            BasicFieldsEnum::CLOSING_DAY_DB => $item->getClosingDay(),
        ];
    }

    /**
     * @param CreditCardDTO $item
     * @return CreditCardVO
     */
    public function dtoToVo($item): CreditCardVO
    {
        return CreditCardVO::makeCreditCardVO(
            $item->getId(),
            $item->getName(),
            $item->getLimit(),
            $item->getDueDate(),
            $item->getClosingDay(),
            $item->getCreatedAt(),
            $item->getUpdatedAt(),
            $item->getTotalValueSpending(),
            $item->getNextInvoiceValue()
        );
    }

    public function transactionToInvoiceDTO(array $item): InvoiceItemDTO
    {
        return new InvoiceItemDTO(
            $item[BasicFieldsEnum::ID],
            $item[BasicFieldsEnum::CREDIT_CARD_ID_DB],
            null,
            $item[BasicFieldsEnum::NAME],
            $item[BasicFieldsEnum::VALUE],
            $item[BasicFieldsEnum::NEXT_INSTALLMENT_DB],
            $item[BasicFieldsEnum::INSTALLMENTS]
        );
    }
}