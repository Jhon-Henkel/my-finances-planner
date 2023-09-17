<?php

namespace App\DTO\Tools;

class MonthlyClosingDTO
{
    public function __construct(
        private readonly null|int $id,
        private readonly null|float $predictedEarnings,
        private readonly null|float $predictedExpenses,
        private null|float $realEarnings = null,
        private null|float $realExpenses = null,
        private null|float $balance = null,
        private readonly mixed $createdAt = null,
        private readonly mixed $updatedAt = null,
        private readonly null|int $tenantId = null
    ) {
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
        $this->balance = round($this->realEarnings - $this->realExpenses, 2);
    }

    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }

    public function getTenantId(): ?int
    {
        return $this->tenantId;
    }
}