<?php

namespace App\DTO;

class CreditCardTransactionDTO
{
    private null|int $id;
    private int $creditCardId;
    private string $name;
    private int|float $value;
    private int $installments;
    private string $firstInstallment;
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
    public function getFirstInstallment(): string
    {
        return $this->firstInstallment;
    }

    /**
     * @param string $firstInstallment
     */
    public function setFirstInstallment(string $firstInstallment): void
    {
        $this->firstInstallment = $firstInstallment;
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