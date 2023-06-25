<?php

namespace App\DTO;

class MonthlyClosingDTO
{
    private null|int $id;
    private null|float $predictedEarnings;
    private null|float $predictedExpenses;
    private null|float $realEarnings;
    private null|float $realExpenses;
    private null|float $balance;
    private mixed $createdAt;
    private mixed $updatedAt;

    public function __construct(
        null|int $id,
        null|float $predictedEarnings,
        null|float $predictedExpenses,
        null|float $realEarnings,
        null|float $realExpenses,
        null|float $balance,
        mixed $createdAt,
        mixed $updatedAt
    ) {
        $this->id = $id;
        $this->predictedEarnings = $predictedEarnings;
        $this->predictedExpenses = $predictedExpenses;
        $this->realEarnings = $realEarnings;
        $this->realExpenses = $realExpenses;
        $this->balance = $balance;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPredictedEarnings(): ?float
    {
        return $this->predictedEarnings;
    }

    public function getPredictedExpenses(): ?float
    {
        return $this->predictedExpenses;
    }

    public function getRealEarnings(): ?float
    {
        return $this->realEarnings;
    }

    public function setRealEarning(null|float $realEarnings): void
    {
        $this->realEarnings = $realEarnings;
    }

    public function getRealExpenses(): ?float
    {
        return $this->realExpenses;
    }

    public function setRealExpenses(null|float $realExpenses): void
    {
        $this->realExpenses = $realExpenses;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(): void
    {
        $this->balance = $this->realEarnings - $this->realExpenses;
    }

    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }
}