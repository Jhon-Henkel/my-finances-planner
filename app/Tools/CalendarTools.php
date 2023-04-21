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

    public static function mountDateToPayInvoice(int $month): string
    {
        $date = self::getDateNow();
        $year = $date->format(DateEnum::ONLY_COMPLETE_YEAR);
        $thisMonth = (int)$date->format(DateEnum::ONLY_MONTH);
        if ($thisMonth == $month) {
            return $year . '-' . $month;
        }
        if ($thisMonth > $month) {
            $year = (int)$year + 1;
        }
        return $year . '-' . $month;
    }

    public static function getNextInstallment(string $nextInstallment): string
    {
        $explodeDate = explode('-', $nextInstallment);
        $year = (int)$explodeDate[0];
        $month = (int)$explodeDate[1];
        if ($month == DateEnum::DECEMBER_MONTH_NUMBER) {
            return ($year + 1) . '-' . DateEnum::JANUARY_MONTH_NUMBER;
        }
        return $year . '-' . ($month + 1);
    }
}