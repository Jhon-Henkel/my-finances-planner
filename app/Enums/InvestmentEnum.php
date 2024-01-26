<?php

namespace App\Enums;

enum InvestmentEnum: int
{
    case Cdb = 1;
    case CdbCreditLimit = 2;

    public static function getAllCdbIdTypes(): array
    {
        return [
            self::Cdb->value,
            self::CdbCreditLimit->value
        ];
    }
}