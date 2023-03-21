<?php

namespace App\Enums;

class DateEnum
{
    const MODEL_DEFAULT_DATE_FORMAT = 'datetime:Y-m-d H:i:s';
    const DATE_START_NAME = 'dateStart';
    const DATE_END_NAME = 'dateEnd';
    const DEFAULT_BR_DATE_FORMAT = 'd/m/Y H:i:s';
    const ONLY_MONTH = 'm';
    const ONLY_COMPLETE_YEAR = 'Y';
    const STRING_JANUARY = 'Janeiro';
    const STRING_FEBRUARY = 'Fevereiro';
    const STRING_MARCH = 'Março';
    const STRING_APRIL = 'Abril';
    const STRING_MAY = 'Maio';
    const STRING_JUNE = 'Junho';
    const STRING_JULY = 'Julho';
    const STRING_AUGUST = 'Agosto';
    const STRING_SEPTEMBER = 'Setembro';
    const STRING_OCTOBER = 'Outubro';
    const STRING_NOVEMBER = 'Novembro';
    const STRING_DECEMBER = 'Dezembro';
    const INT_JANUARY = 1;
    const INT_FEBRUARY = 2;
    const INT_MARCH = 3;
    const INT_APRIL = 4;
    const INT_MAY = 5;
    const INT_JUNE = 6;
    const INT_JULY = 7;
    const INT_AUGUST = 8;
    const INT_SEPTEMBER = 9;
    const INT_OCTOBER = 10;
    const INT_NOVEMBER = 11;
    const INT_DECEMBER = 12;

    public static function getIntMonthByName(string $name): int
    {
        return match (strtolower($name)) {
            strtolower(self::STRING_JANUARY) => self::INT_JANUARY,
            strtolower(self::STRING_FEBRUARY) => self::INT_FEBRUARY,
            strtolower(self::STRING_MARCH) => self::INT_MARCH,
            strtolower(self::STRING_APRIL) => self::INT_APRIL,
            strtolower(self::STRING_MAY) => self::INT_MAY,
            strtolower(self::STRING_JUNE) => self::INT_JUNE,
            strtolower(self::STRING_JULY) => self::INT_JULY,
            strtolower(self::STRING_AUGUST) => self::INT_AUGUST,
            strtolower(self::STRING_SEPTEMBER) => self::INT_SEPTEMBER,
            strtolower(self::STRING_OCTOBER) => self::INT_OCTOBER,
            strtolower(self::STRING_NOVEMBER) => self::INT_NOVEMBER,
            strtolower(self::STRING_DECEMBER) => self::INT_DECEMBER
        };
    }

    public static function getStrMonthByNumber(int $number): int
    {
        return match ($number) {
            self::INT_JANUARY => self::STRING_JANUARY,
            self::INT_FEBRUARY => self::STRING_FEBRUARY,
            self::INT_MARCH => self::STRING_MARCH,
            self::INT_APRIL => self::STRING_APRIL,
            self::INT_MAY => self::STRING_MAY,
            self::INT_JUNE => self::STRING_JUNE,
            self::INT_JULY => self::STRING_JULY,
            self::INT_AUGUST => self::STRING_AUGUST,
            self::INT_SEPTEMBER => self::STRING_SEPTEMBER,
            self::INT_OCTOBER => self::STRING_OCTOBER,
            self::INT_NOVEMBER => self::STRING_NOVEMBER,
            self::INT_DECEMBER => self::STRING_DECEMBER
        };
    }
}