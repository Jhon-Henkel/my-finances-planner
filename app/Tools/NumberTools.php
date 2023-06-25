<?php

namespace App\Tools;

class NumberTools
{
    public static function roundFloatAmount(float|int $amount): float
    {
        return round($amount, 2);
    }
}