<?php

namespace App\DTO;

class CreditCardDTO
{
    private ?int $id;
    private string $name;
    private float $limit;
    private int $dueDate;
    private int $closingDay;
    private null|float $totalValueSpending;
    private null|float $nextInvoiceValue;
    private mixed $createdAt;
    private mixed $updatedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getLimit(): float
    {
        return $this->limit;
    }

    /**
     * @param float $limit
     */
    public function setLimit(float $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getDueDate(): int
    {
        return $this->dueDate;
    }

    /**
     * @param int $dueDate
     */
    public function setDueDate(int $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return int
     */
    public function getClosingDay(): int
    {
        return $this->closingDay;
    }

    /**
     * @param int $closingDay
     */
    public function setClosingDay(int $closingDay): void
    {
        $this->closingDay = $closingDay;
    }

    /**
     * @return float|null
     */
    public function getTotalValueSpending(): ?float
    {
        return $this->totalValueSpending;
    }

    /**
     * @param float|null $totalValueSpending
     */
    public function setTotalValueSpending(?float $totalValueSpending): void
    {
        $this->totalValueSpending = $totalValueSpending;
    }

    /**
     * @return float|null
     */
    public function getNextInvoiceValue(): ?float
    {
        return $this->nextInvoiceValue;
    }

    /**
     * @param float|null $nextInvoiceValue
     */
    public function setNextInvoiceValue(?float $nextInvoiceValue): void
    {
        $this->nextInvoiceValue = $nextInvoiceValue;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt(mixed $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt(mixed $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}