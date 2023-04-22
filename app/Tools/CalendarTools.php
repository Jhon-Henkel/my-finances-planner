<?php

namespace App\Tools;

use App\Enums\DateEnum;
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

    public static function getNextSixMonths(int $thisMonth): array
    {
        // todo melhorar esse métodoo
        $nextMonths = [];
        for ($index = $thisMonth; $index <= 12; $index++) {
            $nextMonths[] = str_pad($index, 2, '0', STR_PAD_LEFT);
            if (count($nextMonths) == 6) {
                break;
            }
        }
        $count = count($nextMonths);
        if ($count < 6) {
            $lack = 6 - $count;
            for ($index = 1; $index <= $lack; $index++) {
                $nextMonths[] = str_pad($index, 2, '0', STR_PAD_LEFT);
            }
        }
        return $nextMonths;
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

    public static function getDayFromDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format(DateEnum::ONLY_DAY);
    }

    public static function mountDateToPayInvoice(int $month, DateTime $now): string
    {
        $year = $now->format(DateEnum::ONLY_COMPLETE_YEAR);
        $thisMonth = (int)$now->format(DateEnum::ONLY_MONTH);
        if ($thisMonth == $month) {
            return $year . '-' . $month;
        }
        if ($thisMonth > $month) {
            $year = (int)$year + 1;
        }
        return $year . '-' . $month;
    }

    public static function getNextInstallment(string $installmentDate): string
    {
        $explodeDate = explode('-', $installmentDate);
        $year = (int)$explodeDate[0];
        $month = (int)$explodeDate[1];
        if ($month == DateEnum::DECEMBER_MONTH_NUMBER) {
            return ($year + 1) . '-' . DateEnum::JANUARY_MONTH_NUMBER;
        }
        return $year . '-' . ($month + 1);
    }

    public static function getThisMonthPeriod(int $thisMonth, int $thisYear): array
    {
        $startDate = self::mountStringDateTime($thisYear, $thisMonth, 1, '00:00:00');
        $lastDay = self::getLastDayOfData($startDate);
        $endDate = self::mountStringDateTime($thisYear, $thisMonth, $lastDay, '23:59:59');
        return ['start' => $startDate, 'end' => $endDate];
    }

    public static function getLastMonthPeriod(int $thisMonth, int $thisYear): array
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
        return ['start' => $startDate, 'end' => $endDate];
    }

    public static function getThisYearPeriod(int $year): array
    {
        $startDate = self::mountStringDateTime($year, DateEnum::JANUARY_MONTH_NUMBER, 1, '00:00:00');
        $endDate = self::mountStringDateTime($year, DateEnum::DECEMBER_MONTH_NUMBER, 31, '23:59:59');
        return ['start' => $startDate, 'end' => $endDate];
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
}