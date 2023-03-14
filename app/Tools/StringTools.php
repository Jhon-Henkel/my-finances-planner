<?php

namespace App\Tools;

class StringTools
{
    public static function moneyBr(int|float $value): string
    {
        return'R$ ' . number_format($value, 2, ',', '.');
    }
}