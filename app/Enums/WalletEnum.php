<?php

namespace App\Enums;

class WalletEnum
{
    const MONEY_TYPE = 5;
    const BANK_COUNT_TYPE = 6;
    const CREDIT_CARD_TYPE = 7;
    const MEAL_TICKET_TYPE = 8;
    const TRANSPORT_TICKET_TYPE = 9;

    protected static function getDescription(int $value): string
    {
        return match ($value) {
            self::MONEY_TYPE => 'Dinheiro',
            self::BANK_COUNT_TYPE => 'Conta Bancária',
            self::CREDIT_CARD_TYPE => 'Cartão de crédito',
            self::MEAL_TICKET_TYPE => 'Vale Alimentação',
            self::TRANSPORT_TICKET_TYPE => 'Vale Transporte',
            default => 'Desconhecido'
        };
    }
}
