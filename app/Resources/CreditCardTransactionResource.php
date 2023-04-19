<?php

namespace App\Resources;

use App\DTO\CreditCardTransactionDTO;
use App\Enums\BasicFieldsEnum;
use App\VO\CreditCardTransactionVO;

class CreditCardTransactionResource extends BasicResource
{
    public function arrayToDto(array $item): CreditCardTransactionDTO
    {
        $creditCardId = $item[BasicFieldsEnum::CREDIT_CARD_ID_DB] ?? $item[BasicFieldsEnum::CREDIT_CARD_ID_JSON];
        $firstInstallment = $item[BasicFieldsEnum::FIRST_INSTALLMENT_DB] ?? $item[BasicFieldsEnum::FIRST_INSTALLMENT_JSON];
        $dto = new CreditCardTransactionDTO();
        $dto->setId($item[BasicFieldsEnum::ID] ?? null);
        $dto->setName($item[BasicFieldsEnum::NAME]);
        $dto->setValue($item[BasicFieldsEnum::VALUE]);
        $dto->setInstallments($item[BasicFieldsEnum::INSTALLMENTS]);
        $dto->setCreditCardId($creditCardId);
        $dto->setFirstInstallment($firstInstallment);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    /**
     * @param CreditCardTransactionDTO $item
     * @return array
     */
    public function dtoToArray($item): array
    {
        return [
            BasicFieldsEnum::NAME => $item->getName(),
            BasicFieldsEnum::VALUE => $item->getValue(),
            BasicFieldsEnum::INSTALLMENTS => $item->getInstallments(),
            BasicFieldsEnum::CREDIT_CARD_ID_DB => $item->getCreditCardId(),
            BasicFieldsEnum::FIRST_INSTALLMENT_DB => $item->getFirstInstallment(),
        ];
    }

    /**
     * @param CreditCardTransactionDTO $item
     * @return CreditCardTransactionVO
     */
    public function dtoToVo($item): CreditCardTransactionVO
    {
        return CreditCardTransactionVO::makeCreditCardTransactionVO(
            $item->getId(),
            $item->getName(),
            $item->getValue(),
            $item->getInstallments(),
            $item->getFirstInstallment(),
            $item->getCreditCardId(),
            $item->getCreatedAt(),
            $item->getUpdatedAt()
        );
    }
}