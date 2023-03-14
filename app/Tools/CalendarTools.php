<?php

namespace App\Tools;

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

    public static function usToBrDate(string $date): string
    {
        $date = new \DateTime($date);
        return $date->format('d/m/Y H:m:s');
    }
}