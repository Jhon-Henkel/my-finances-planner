<?php

namespace App\DTO\Movement;

class MovementSumValuesDTO
{
    private float $earnings;
    private float $expenses;
    private float $balance;

    public function __construct(float $earnings, float $expenses, float $balance)
    {
        $this->earnings = $earnings;
        $this->expenses = $expenses;
        $this->balance = $balance;
    }

    public function getEarnings(): float
    {
        return $this->earnings;
    }

    public function getExpenses(): float
    {
        return $this->expenses;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}