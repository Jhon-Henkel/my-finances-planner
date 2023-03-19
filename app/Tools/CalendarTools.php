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
}