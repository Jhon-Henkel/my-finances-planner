<?php

namespace App\Enums;

enum CalendarMonthsNumberEnum: int
{
    case January = 1;
    case February = 2;
    case March = 3;
    case April = 4;
    case May = 5;
    case June = 6;
    case July = 7;
    case August = 8;
    case September = 9;
    case October = 10;
    case November = 11;
    case December = 12;

    public function label(): string
    {
        return self::getMonthName($this->value);
    }

    public static function getMonthName(int $month): string
    {
        // @phpstan-ignore-next-line
        return match($month) {
            self::January->value => 'Janeiro',
            self::February->value => 'Fevereiro',
            self::March->value => 'Março',
            self::April->value => 'Abril',
            self::May->value => 'Maio',
            self::June->value => 'Junho',
            self::July->value => 'Julho',
            self::August->value => 'Agosto',
            self::September->value => 'Setembro',
            self::October->value => 'Outubro',
            self::November->value => 'Novembro',
            self::December->value => 'Dezembro',
        };
    }
}
