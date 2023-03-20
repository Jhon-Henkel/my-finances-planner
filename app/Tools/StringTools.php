<?php

namespace App\Tools;

class StringTools
{
    public static function moneyBr(int|float $value): string
    {
        return'R$ ' . number_format($value, 2, ',', '.');
    }

    public static function crudMoneyToFloat(string $value): float
    {
        $amount = str_replace('.', '', $value);
        $amount = str_replace(',', '.', $amount);
        return (float)$amount;
    }
}