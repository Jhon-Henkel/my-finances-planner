<?php

namespace App\Enums;

class DateEnum
{
    const MODEL_DEFAULT_DATE_FORMAT = 'datetime:Y-m-d H:i:s';
    const DATE_START_NAME = 'dateStart';
    const DATE_END_NAME = 'dateEnd';
    const DEFAULT_BR_DATE_FORMAT = 'd/m/Y H:i:s';
    const ONLY_MONTH = 'm';
    const ONLY_DAY = 'd';
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
    const NUMBER_JANUARY = '01';
    const NUMBER_FEBRUARY = '02';
    const NUMBER_MARCH = '03';
    const NUMBER_APRIL = '04';
    const NUMBER_MAY = '05';
    const NUMBER_JUNE = '06';
    const NUMBER_JULY = '07';
    const NUMBER_AUGUST = '08';
    const NUMBER_SEPTEMBER = '09';
    const NUMBER_OCTOBER = '10';
    const NUMBER_NOVEMBER = '11';
    const NUMBER_DECEMBER = '12';

    public static function getIntMonthByName(string $name): string
    {
        return match (strtolower($name)) {
            strtolower(self::STRING_JANUARY) => self::NUMBER_JANUARY,
            strtolower(self::STRING_FEBRUARY) => self::NUMBER_FEBRUARY,
            strtolower(self::STRING_MARCH) => self::NUMBER_MARCH,
            strtolower(self::STRING_APRIL) => self::NUMBER_APRIL,
            strtolower(self::STRING_MAY) => self::NUMBER_MAY,
            strtolower(self::STRING_JUNE) => self::NUMBER_JUNE,
            strtolower(self::STRING_JULY) => self::NUMBER_JULY,
            strtolower(self::STRING_AUGUST) => self::NUMBER_AUGUST,
            strtolower(self::STRING_SEPTEMBER) => self::NUMBER_SEPTEMBER,
            strtolower(self::STRING_OCTOBER) => self::NUMBER_OCTOBER,
            strtolower(self::STRING_NOVEMBER) => self::NUMBER_NOVEMBER,
            strtolower(self::STRING_DECEMBER) => self::NUMBER_DECEMBER
        };
    }

    public static function getStrMonthByNumber(string $number): string
    {
        return match ($number) {
            self::NUMBER_JANUARY => self::STRING_JANUARY,
            self::NUMBER_FEBRUARY => self::STRING_FEBRUARY,
            self::NUMBER_MARCH => self::STRING_MARCH,
            self::NUMBER_APRIL => self::STRING_APRIL,
            self::NUMBER_MAY => self::STRING_MAY,
            self::NUMBER_JUNE => self::STRING_JUNE,
            self::NUMBER_JULY => self::STRING_JULY,
            self::NUMBER_AUGUST => self::STRING_AUGUST,
            self::NUMBER_SEPTEMBER => self::STRING_SEPTEMBER,
            self::NUMBER_OCTOBER => self::STRING_OCTOBER,
            self::NUMBER_NOVEMBER => self::STRING_NOVEMBER,
            self::NUMBER_DECEMBER => self::STRING_DECEMBER
        };
    }
}