<?php

namespace App\Enums;

class WalletEnum
{
    const MONEY_TYPE = 5;
    const BANK_COUNT_TYPE = 6;
    const CREDIT_CARD_TYPE = 7;

    protected static function getDescription(int $value): string
    {
        return match ($value) {
            self::MONEY_TYPE => 'Dinheiro',
            self::BANK_COUNT_TYPE => 'Conta Bancária',
            self::CREDIT_CARD_TYPE => 'Cartão de crédito',
            default => 'Desconhecido'
        };
    }
}
