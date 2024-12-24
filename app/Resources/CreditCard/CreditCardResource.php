<?php

namespace App\Resources\CreditCard;

use App\DTO\CreditCard\CreditCardDTO;
use App\DTO\InvoiceItemDTO;
use App\Resources\BasicResource;
use App\VO\CreditCard\CreditCardVO;

class CreditCardResource extends BasicResource
{
    public function arrayToDto(array $item): CreditCardDTO
    {
        if (isset($item['active'])) {
            $item['status'] = (int)$item['active'];
        }
        $dto = new CreditCardDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setName($item['name']);
        $dto->setLimit($item['limit']);
        $dto->setStatus($item['status']);
        $dto->setDueDate($item['due_date'] ?? $item['dueDate']);
        $dto->setClosingDay($item['closing_day'] ?? $item['closingDay']);
        $dto->setNextInvoiceValue(null);
        $dto->setTotalValueSpending(null);
        $dto->setIsThinsMouthInvoicePayed(null);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    public function dtoToArray($item): array
    {
        return [
            'name' => $item->getName(),
            'limit' => $item->getLimit(),
            'due_date' => $item->getDueDate(),
            'closing_day' => $item->getClosingDay(),
            'status' => $item->getStatus(),
        ];
    }

    /** @param CreditCardDTO $item */
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
            $item->getNextInvoiceValue(),
            $item->getIsThinsMouthInvoicePayed(),
            $item->getStatus()
        );
    }

    public function transactionToInvoiceDTO(array $item): InvoiceItemDTO
    {
        return new InvoiceItemDTO(
            $item['id'],
            $item['credit_card_id'],
            null,
            $item['name'],
            $item['value'],
            $item['next_installment'],
            $item['installments']
        );
    }
}
