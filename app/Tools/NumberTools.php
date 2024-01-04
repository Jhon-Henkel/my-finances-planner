<?php

namespace App\Tools;

class NumberTools
{
    public static function roundFloatAmount(float|int $amount): float
    {
        return round($amount, 2);
    }

    public static function makeBalance(float|int $gain, float|int $loss): float
    {
        if ($loss === 0) {
            return self::roundFloatAmount($gain);
        }
        return self::roundFloatAmount($gain - $loss);
    }
}
