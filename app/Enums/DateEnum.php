<?php

namespace App\Enums;

class DateEnum
{
    const MODEL_DEFAULT_DATE_FORMAT = 'datetime:Y-m-d H:i:s';
    const DEFAULT_BR_DATE_FORMAT = 'd/m/Y H:i:s';
    const DEFAULT_DB_DATE_FORMAT = 'Y-m-d H:i:s';
    const USA_DATE_FORMAT_WITHOUT_TIME = 'Y-m-d';
    const ONLY_MONTH = 'm';
    const ONLY_DAY = 'd';
    const ONLY_COMPLETE_YEAR = 'Y';
    const JANUARY_MONTH_NUMBER = 1;
    const FEBRUARY_MONTH_NUMBER = 2;
    const MARCH_MONTH_NUMBER = 3;
    const APRIL_MONTH_NUMBER = 4;
    const MAY_MONTH_NUMBER = 5;
    const JUNE_MONTH_NUMBER = 6;
    const JULY_MONTH_NUMBER = 7;
    const AUGUST_MONTH_NUMBER = 8;
    const SEPTEMBER_MONTH_NUMBER = 9;
    const OCTOBER_MONTH_NUMBER = 10;
    const NOVEMBER_MONTH_NUMBER = 11;
    const DECEMBER_MONTH_NUMBER = 12;
    const TWO_HOUR_IN_SECONDS = 7200;
    const TREE_HOUR_IN_SECONDS = 10800;

    public static function getMonthNameByNumber(int $month): string
    {
        return match($month) {
            self::JANUARY_MONTH_NUMBER => 'Janeiro',
            self::FEBRUARY_MONTH_NUMBER => 'Fevereiro',
            self::MARCH_MONTH_NUMBER => 'Março',
            self::APRIL_MONTH_NUMBER => 'Abril',
            self::MAY_MONTH_NUMBER => 'Maio',
            self::JUNE_MONTH_NUMBER => 'Junho',
            self::JULY_MONTH_NUMBER => 'Julho',
            self::AUGUST_MONTH_NUMBER => 'Agosto',
            self::SEPTEMBER_MONTH_NUMBER => 'Setembro',
            self::OCTOBER_MONTH_NUMBER => 'Outubro',
            self::NOVEMBER_MONTH_NUMBER => 'Novembro',
            self::DECEMBER_MONTH_NUMBER => 'Dezembro',
        };
    }
}