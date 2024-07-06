<?php

namespace App\Enums;

enum MovementEnum: int
{
    case All = 0;
    case FilterByThisMonth = 2;
    case FilterByLastMonth = 3;
    case FilterByThisYear = 4;
    case Spent = 5;
    case Gain = 6;
    case Transfer = 7;
    case InvestmentCdb = 8;

    public static function getTypesValidForFilter(): array
    {
        return [
            MovementEnum::Transfer->value,
            MovementEnum::Gain->value,
            MovementEnum::Spent->value,
            MovementEnum::InvestmentCdb->value,
        ];
    }
}
