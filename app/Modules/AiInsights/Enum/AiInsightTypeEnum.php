<?php

namespace App\Modules\AiInsights\Enum;

enum AiInsightTypeEnum: int
{
    case FinancialHealth = 1;

    public static function type(int $value): string
    {
        return match ($value) {
            self::FinancialHealth->value => 'financial_health',
            default => 'unknown'
        };
    }
}
