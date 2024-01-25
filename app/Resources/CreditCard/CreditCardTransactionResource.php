<?php

namespace App\Resources\CreditCard;

use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\Enums\BasicFieldsEnum;
use App\Resources\BasicResource;
use App\VO\CreditCard\CreditCardTransactionVO;

class CreditCardTransactionResource extends BasicResource
{
    public function arrayToDto(array $item): CreditCardTransactionDTO
    {
        $creditCardId = $item[BasicFieldsEnum::CREDIT_CARD_ID_DB] ?? $item[BasicFieldsEnum::CREDIT_CARD_ID_JSON];
        $nextInstallment = $item[BasicFieldsEnum::NEXT_INSTALLMENT_DB] ?? $item[BasicFieldsEnum::NEXT_INSTALLMENT_JSON];
        $dto = new CreditCardTransactionDTO();
        $dto->setId($item[BasicFieldsEnum::ID] ?? null);
        $dto->setName($item[BasicFieldsEnum::NAME]);
        $dto->setValue($item[BasicFieldsEnum::VALUE]);
        $dto->setInstallments($item[BasicFieldsEnum::INSTALLMENTS]);
        $dto->setCreditCardId($creditCardId);
        $dto->setNextInstallment($nextInstallment);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    /** @param CreditCardTransactionDTO $item */
    public function dtoToArray($item): array
    {
        return [
            BasicFieldsEnum::NAME => $item->getName(),
            BasicFieldsEnum::VALUE => $item->getValue(),
            BasicFieldsEnum::INSTALLMENTS => $item->getInstallments(),
            BasicFieldsEnum::CREDIT_CARD_ID_DB => $item->getCreditCardId(),
            BasicFieldsEnum::NEXT_INSTALLMENT_DB => $item->getNextInstallment(),
        ];
    }

    /** @param CreditCardTransactionDTO $item */
    public function dtoToVo($item): CreditCardTransactionVO
    {
        return CreditCardTransactionVO::makeCreditCardTransactionVO(
            $item->getId(),
            $item->getName(),
            $item->getValue(),
            $item->getInstallments(),
            $item->getNextInstallment(),
            $item->getCreditCardId(),
            $item->getCreatedAt(),
            $item->getUpdatedAt()
        );
    }
}