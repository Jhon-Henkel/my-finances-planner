<?php

namespace App\Tools;

class StringTools
{
    public static function moneyBr(int|float $value): string
    {
        return'R$ ' . number_format($value, 2, ',', '.');
    }

    public static function crudMoneyToFloat(string $value): float
    {
        $amount = str_replace('.', '', $value);
        $amount = str_replace(',', '.', $amount);
        return (float)$amount;
    }

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
}