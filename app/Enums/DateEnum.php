<?php

namespace App\Enums;

class DateEnum
{
    const MODEL_DEFAULT_DATE_FORMAT = 'datetime:Y-m-d H:i:s';
    const DEFAULT_BR_DATE_FORMAT = 'd/m/Y H:i:s';
    const DEFAULT_DB_DATE_FORMAT = 'Y-m-d H:i:s';
    const ONLY_MONTH = 'm';
    const ONLY_DAY = 'd';
    const ONLY_COMPLETE_YEAR = 'Y';
    const DECEMBER_MONTH_NUMBER = 12;
    const JANUARY_MONTH_NUMBER = 1;
}