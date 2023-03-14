<?php

namespace App\Enums;

class MovementEnum
{
    const SPENT = 5;
    const GAIN = 6;
    const TRANSFER = 7;

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::SPENT => 'Gasto',
            self::GAIN => 'Ganho',
            self::TRANSFER => 'Transferência',
            default => 'Desconhecido'
        };
    }
}