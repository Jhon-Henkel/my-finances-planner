<?php

namespace App\VO\Tools;

class MonthlyClosingVO
{
    public null|int $id;
    public null|float $predictedEarnings;
    public null|float $predictedExpenses;
    public null|float $realEarnings;
    public null|float $realExpenses;
    public null|float $balance;
    public mixed $createdAt;
    public mixed $updatedAt;
    public null|int $tenantId;

    public function __construct(
        null|int $id,
        null|float $predictedEarnings,
        null|float $predictedExpenses,
        null|float $realEarnings,
        null|float $realExpenses,
        null|float $balance,
        mixed $createdAt,
        mixed $updatedAt,
        null|int $tenantId = null
    ) {
        $this->id = $id;
        $this->predictedEarnings = $predictedEarnings;
        $this->predictedExpenses = $predictedExpenses;
        $this->realEarnings = $realEarnings;
        $this->realExpenses = $realExpenses;
        $this->balance = $balance;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->tenantId = $tenantId;
    }
}
