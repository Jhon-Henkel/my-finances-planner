<?php

namespace App\Tools\Calendar;

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
