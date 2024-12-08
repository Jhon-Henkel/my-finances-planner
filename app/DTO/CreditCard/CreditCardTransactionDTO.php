<?php

namespace App\DTO\CreditCard;

class CreditCardTransactionDTO
{
    private null|int $id;
    private int $creditCardId;
    private string $name;
    private int|float $value;
    private int $installments;
    private string $nextInstallment;
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

    public function getCreditCardId(): int
    {
        return $this->creditCardId;
    }

    public function setCreditCardId(int $creditCardId): void
    {
        $this->creditCardId = $creditCardId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getValue(): float|int
    {
        return $this->value;
    }

    public function setValue(float|int $value): void
    {
        $this->value = $value;
    }

    public function getInstallments(): int
    {
        return $this->installments;
    }

    public function setInstallments(int $installments): void
    {
        $this->installments = $installments;
    }

    public function getNextInstallment(): string
    {
        return $this->nextInstallment;
    }

    public function setNextInstallment(string $nextInstallment): void
    {
        $this->nextInstallment = $nextInstallment;
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

    public function isMarketSpent(): bool
    {
        return strtolower($this->getName()) == 'mercado';
    }
}
