<?php

namespace App\Enums;

class WalletEnum
{
    const MONEY_TYPE = 5;
    const BANK_COUNT_TYPE = 6;
    const CREDIT_CARD_TYPE = 7;
    const MEAL_TICKET_TYPE = 8;
    const TRANSPORT_TICKET_TYPE = 9;
    const OTHER_TYPE = 0;

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::MONEY_TYPE => 'Dinheiro',
            self::BANK_COUNT_TYPE => 'Conta Bancária',
            self::CREDIT_CARD_TYPE => 'Cartão de crédito',
            self::MEAL_TICKET_TYPE => 'Vale Alimentação',
            self::TRANSPORT_TICKET_TYPE => 'Vale Transporte',
            self::OTHER_TYPE => 'Outros',
            default => 'Desconhecido'
        };
    }

    public static function getCode(string $description): int
    {
        return match ($description) {
            'Dinheiro' => self::MONEY_TYPE,
            'Conta Bancária' => self::BANK_COUNT_TYPE,
            'Cartão de crédito' => self::CREDIT_CARD_TYPE,
            'Vale Alimentação' => self::MEAL_TICKET_TYPE,
            'Vale Transporte' => self::TRANSPORT_TICKET_TYPE,
            default => self::OTHER_TYPE
        };
    }

    public static function getList(): array
    {
        $reflect = new \ReflectionClass(WalletEnum::class);
        $list = array();
        foreach ($reflect->getConstants() as $value){
            $list[$value] = self::getDescription($value);
        }
        return $list;
    }
}