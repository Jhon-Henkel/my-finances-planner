<?php

namespace App\Enums;

class MovementEnum
{
    const SPENT = 5;
    const GAIN = 6;
    const TRANSFER = 7;
    const FILTER_THIS_MONTH = 10;
    const FILTER_LAST_MONTH = 11;
    const FILTER_THIS_YEAR = 12;
    const FILTER_ALL = 13;

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::SPENT => 'Gasto',
            self::GAIN => 'Ganho',
            self::TRANSFER => 'Transferência',
            self::FILTER_THIS_MONTH => 'Este mês',
            self::FILTER_LAST_MONTH => 'Ultimo mês',
            self::FILTER_THIS_YEAR => 'Este ano',
            self::FILTER_ALL => 'Tudo',
            default => 'Desconhecido'
        };
    }
}