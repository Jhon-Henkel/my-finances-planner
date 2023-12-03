<?php

namespace App\Enums;

class MovementEnum
{
    const ALL = 0;
    const FILTER_BY_THIS_MONTH = 2;
    const FILTER_BY_LAST_MONTH = 3;
    const FILTER_BY_THIS_YEAR = 4;
    const SPENT = 5;
    const GAIN = 6;
    const TRANSFER = 7;
    const INVESTMENT_CDB = 8;

    public static function getTypesValidForFilter(): array
    {
        return [
            MovementEnum::TRANSFER,
            MovementEnum::GAIN,
            MovementEnum::SPENT,
            MovementEnum::INVESTMENT_CDB
        ];
    }
}