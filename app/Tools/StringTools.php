<?php

namespace App\Tools;

class StringTools
{
    public static function removeMonthNameFromString(string $string): string
    {
        $months = [
            'janeiro', 'Janeiro', 'fevereiro', 'Fevereiro', 'março', 'Março',
            'abril', 'Abril', 'maio', 'Maio', 'junho', 'Junho', 'julho', 'Julho',
            'agosto', 'Agosto', 'setembro', 'Setembro', 'outubro', 'Outubro',
            'novembro', 'Novembro', 'dezembro', 'Dezembro'
        ];
        return str_replace($months, '', $string);
    }

    public static function removeExtraSpacesFromString(string $string): string
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    public static function generateRandomHexColor(): string
    {
        return sprintf("#%06x", rand(0, 16777215));
    }
}
