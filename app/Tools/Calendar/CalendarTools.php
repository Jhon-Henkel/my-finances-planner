<?php

namespace App\Tools\Calendar;

use App\DTO\Date\DatePeriodDTO;
use App\Enums\DateFormatEnum;
use DateTime;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin CalendarToolsReal
 */
class CalendarTools extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CalendarToolsReal::class;
    }
}
