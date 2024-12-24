<?php

namespace App\DTO\CreditCard;

use App\Enums\StatusEnum;

class CreditCardDTO
{
    private ?int $id;
    private string $name;
    private float $limit;
    private int $dueDate;
    private int $closingDay;
    private int $status = StatusEnum::Active->value;
    private null|float $totalValueSpending;
    private null|float $nextInvoiceValue;
    private null|bool $isThinsMouthInvoicePayed = false;
    private mixed $createdAt;
    private mixed $updatedAt;

    public function getId(): null|int
    {
        return $this->id;
    }

    public function setId(null|int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLimit(): float
    {
        return $this->limit;
    }

    public function setLimit(float $limit): void
    {
        $this->limit = $limit;
    }

    public function getDueDate(): int
    {
        return $this->dueDate;
    }

    public function setDueDate(int $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    public function getClosingDay(): int
    {
        return $this->closingDay;
    }

    public function setClosingDay(int $closingDay): void
    {
        $this->closingDay = $closingDay;
    }

    public function getTotalValueSpending(): null|float
    {
        return $this->totalValueSpending;
    }

    public function setTotalValueSpending(null|float $totalValueSpending): void
    {
        $this->totalValueSpending = $totalValueSpending;
    }

    public function getNextInvoiceValue(): null|float
    {
        return $this->nextInvoiceValue;
    }

    public function setNextInvoiceValue(null|float $nextInvoiceValue): void
    {
        $this->nextInvoiceValue = $nextInvoiceValue;
    }

    public function getIsThinsMouthInvoicePayed(): null|bool
    {
        return $this->isThinsMouthInvoicePayed;
    }

    public function setIsThinsMouthInvoicePayed(null|bool $isThinsMouthInvoicePayed): void
    {
        $this->isThinsMouthInvoicePayed = $isThinsMouthInvoicePayed;
    }

    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }

    public function setCreatedAt(mixed $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(mixed $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
