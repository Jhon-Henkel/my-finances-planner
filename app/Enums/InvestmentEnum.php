<?php

namespace App\Enums;

enum InvestmentEnum
{
    const CDB_ID = 1;
    const CDB_CREDIT_LIMIT_ID = 2;

    public static function getAllCdbIdTypes(): array
    {
        return [
            self::CDB_ID,
            self::CDB_CREDIT_LIMIT_ID
        ];
    }
}