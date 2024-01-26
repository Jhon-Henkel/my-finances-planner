<?php

namespace App\Resources\CreditCard;

use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\Resources\BasicResource;
use App\VO\CreditCard\CreditCardTransactionVO;

class CreditCardTransactionResource extends BasicResource
{
    public function arrayToDto(array $item): CreditCardTransactionDTO
    {
        $creditCardId = $item['credit_card_id'] ?? $item['creditCardId'];
        $nextInstallment = $item['next_installment'] ?? $item['nextInstallment'];
        $dto = new CreditCardTransactionDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setName($item['name']);
        $dto->setValue($item['value']);
        $dto->setInstallments($item['installments']);
        $dto->setCreditCardId($creditCardId);
        $dto->setNextInstallment($nextInstallment);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @param CreditCardTransactionDTO $item */
    public function dtoToArray($item): array
    {
        return [
            'name' => $item->getName(),
            'value' => $item->getValue(),
            'installments' => $item->getInstallments(),
            'credit_card_id' => $item->getCreditCardId(),
            'next_installment' => $item->getNextInstallment(),
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