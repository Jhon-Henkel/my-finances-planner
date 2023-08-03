<?php

namespace App\Tools;

use App\DTO\Date\DatePeriodDTO;
use App\Enums\DateEnum;
use DateInterval;
use DateTime;
use Exception;

class CalendarTools
{
    public static function salutation(?string $name, int $hour): string
    {
        if($hour >= 4 && $hour <= 12) {
            return 'Bom dia ' . $name ?? '';
        } else if ($hour > 12 && $hour <19) {
            return 'Boa tarde ' . $name ?? '';
        } else {
            return 'Boa noite ' . $name ?? '';
        }
    }

    /**
     * @throws Exception
     */
    public static function usToBrDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format(DateEnum::DEFAULT_BR_DATE_FORMAT);
    }

    public static function getThisMonth(): string
    {
        $date = self::getDateNow();
        return $date->format(DateEnum::ONLY_MONTH);
    }

    public static function getThisYear(): string
    {
        $date = self::getDateNow();
        return $date->format(DateEnum::ONLY_COMPLETE_YEAR);
    }

    public static function getDateNow(): DateTime
    {
        return new DateTime();
    }

    /**
     * @throws Exception
     */
    public static function getMonthFromDate(string $date): string
    {
        $date = new DateTime($date);
        $month = $date->format(DateEnum::ONLY_MONTH);
        return str_pad($month, 2, '0', STR_PAD_LEFT);
    }

    public static function getYearFromDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format(DateEnum::ONLY_COMPLETE_YEAR);
    }

    public static function getDayFromDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format(DateEnum::ONLY_DAY);
    }

    public static function getThisMonthPeriod(int $thisMonth, int $thisYear): DatePeriodDTO
    {
        $startDate = self::mountStringDateTime($thisYear, $thisMonth, 1, '00:00:00');
        $lastDay = self::getLastDayOfData($startDate);
        $endDate = self::mountStringDateTime($thisYear, $thisMonth, $lastDay, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }

    public static function getLastMonthPeriod(int $thisMonth, int $thisYear): DatePeriodDTO
    {
        if ($thisMonth == DateEnum::JANUARY_MONTH_NUMBER) {
            $lastMonth = DateEnum::DECEMBER_MONTH_NUMBER;
            $year = $thisYear - 1;
        } else {
            $lastMonth = $thisMonth - 1;
            $year = $thisYear;
        }
        $startDate = self::mountStringDateTime($year, $lastMonth,  1, '00:00:00');
        $lastDay = self::getLastDayOfData($startDate);
        $endDate = self::mountStringDateTime($year, $lastMonth, $lastDay, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }

    public static function getThisYearPeriod(int $year): DatePeriodDTO
    {
        $startDate = self::mountStringDateTime($year, DateEnum::JANUARY_MONTH_NUMBER, 1, '00:00:00');
        $endDate = self::mountStringDateTime($year, DateEnum::DECEMBER_MONTH_NUMBER, 31, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }

    public static function getLastFiveYearPeriod(int $year): DatePeriodDTO
    {
        $lastYear = $year - 5;
        $startDate = self::mountStringDateTime($lastYear, DateEnum::JANUARY_MONTH_NUMBER, 1, '00:00:00');
        $endDate = self::mountStringDateTime($year, DateEnum::DECEMBER_MONTH_NUMBER, 31, '23:59:59');
        return new DatePeriodDTO($startDate, $endDate);
    }

    public static function getLastDayOfData(string $data): string
    {
        $day = date('t', strtotime($data));
        return str_pad($day, 2, '0', STR_PAD_LEFT);
    }

    public static function mountStringDateTime(
        string|int $year,
        string|int $month,
        string|int $day,
        string $time
    ): string {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);
        return $year . '-' . $month . '-' . $day . ' ' . $time;
    }

    /**
     * @throws Exception
     */
    public static function addMonthInDate(
        string $date,
        int $months,
        string $format = DateEnum::DEFAULT_DB_DATE_FORMAT
    ): string {
        $date = new DateTime($date);
        return $date->add(new DateInterval('P'. $months . 'M'))->format($format);
    }

    /**
     * @throws Exception
     */
    public static function getIntervalMonthPeriodByMonthAndYear(int $month, int $year, int $interval): DatePeriodDTO
    {
        $dateStart = self::mountStringDateTime($year, $month, 1, '00:00:00');
        $dateEnd = self::addMonthInDate($dateStart, $interval);
        return new DatePeriodDTO($dateStart, $dateEnd);
    }

    public static function getMonthLabelWithYear(string $date): string
    {
        $date = new DateTime($date);
        $month = $date->format(DateEnum::ONLY_MONTH);
        $year = $date->format(DateEnum::ONLY_COMPLETE_YEAR);
        return $month . '/' . $year;
    }

    public static function getMonthPeriodFromDate(string $date): DatePeriodDTO
    {
        $month = self::getMonthFromDate($date);
        $year = self::getYearFromDate($date);
        return self::getThisMonthPeriod($month, $year);
    }
}