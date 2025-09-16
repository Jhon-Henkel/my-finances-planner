<?php

namespace App\Modules\Movement\Enum;

enum MovementTypeEnum: int
{
    case All = 0;
    case Spent = 5;
    case Gain = 6;
    case Transfer = 7;

    public static function getTypesValidForFilter(): array
    {
        return [
            MovementTypeEnum::Transfer->value,
            MovementTypeEnum::Gain->value,
            MovementTypeEnum::Spent->value,
        ];
    }

    public static function getForValidation(): string
    {
        return implode(',', [
            MovementTypeEnum::Transfer->value,
            MovementTypeEnum::Gain->value,
            MovementTypeEnum::Spent->value,
        ]);
    }

    public static function isGain(int $type): bool
    {
        return $type == MovementTypeEnum::Gain->value;
    }

    public static function isSpent(int $type): bool
    {
        return $type == MovementTypeEnum::Spent->value;
    }

    public static function isTransfer(int $type): bool
    {
        return $type == MovementTypeEnum::Transfer->value;
    }
}
