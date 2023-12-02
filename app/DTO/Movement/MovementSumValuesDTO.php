<?php

namespace App\DTO\Movement;

class MovementSumValuesDTO
{
    private float $earnings = 0;
    private float $expenses = 0;
    private float $balance = 0;

    public function addEarnings(float $earning): void
    {
        $this->earnings += $earning;
    }

    public function getEarnings(): float
    {
        return $this->earnings;
    }

    public function addExpenses(float $expense): void
    {
        $this->expenses += $expense;
    }

    public function getExpenses(): float
    {
        return $this->expenses;
    }

    public function getBalance(): float
    {
        return round($this->earnings - $this->expenses, 2);
    }
}