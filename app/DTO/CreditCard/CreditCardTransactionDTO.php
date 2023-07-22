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
     * @return int
     */
    public function getCreditCardId(): int
    {
        return $this->creditCardId;
    }

    /**
     * @param int $creditCardId
     */
    public function setCreditCardId(int $creditCardId): void
    {
        $this->creditCardId = $creditCardId;
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
     * @return float|int
     */
    public function getValue(): float|int
    {
        return $this->value;
    }

    /**
     * @param float|int $value
     */
    public function setValue(float|int $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getInstallments(): int
    {
        return $this->installments;
    }

    /**
     * @param int $installments
     */
    public function setInstallments(int $installments): void
    {
        $this->installments = $installments;
    }

    /**
     * @return string
     */
    public function getNextInstallment(): string
    {
        return $this->nextInstallment;
    }

    /**
     * @param string $nextInstallment
     */
    public function setNextInstallment(string $nextInstallment): void
    {
        $this->nextInstallment = $nextInstallment;
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