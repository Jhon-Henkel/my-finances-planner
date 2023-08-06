<?php

namespace App\Tools\Calendar;

use App\DTO\Date\DatePeriodDTO;
use App\Enums\DateEnum;
use DateTime;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string salutation(null|string $name, int $hour)
 * @method static string stringUsToBrDate(string $date)
 * @method static string getThisMonth()
 * @method static string getThisYear()
 * @method static DateTime getDateNow()
 * @method static string getMonthFromStringDate(string $date)
 * @method static string getYearFromStringDate(string $date)
 * @method static string getDayFromStringDate(string $date)
 * @method static DatePeriodDTO getThisMonthPeriod()
 * @method static DatePeriodDTO getLastMonthPeriod()
 * @method static DatePeriodDTO getThisYearPeriod()
 * @method static DatePeriodDTO getYearPeriod(int $year)
 * @method static DatePeriodDTO getLastFiveYearPeriod()
 * @method static string getLastDayOfData(string $data)
 * @method static string mountStringDateTime(string|int $year, string|int $month, string|int $day, string $time)
 * @method static string addMonthInDate(string $date, int $months, string $format = DateEnum::DEFAULT_DB_DATE_FORMAT)
 * @method static DatePeriodDTO getIntervalMonthPeriodByMonthAndYear(int $month, int $year, int $interval)
 * @method static string getMonthLabelWithYear(string $date)
 * @method static DatePeriodDTO getMonthPeriodFromDate(string $date)
 *
 * @see CalendarToolsReal
 */
class CalendarTools extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CalendarToolsReal::class;
    }
}