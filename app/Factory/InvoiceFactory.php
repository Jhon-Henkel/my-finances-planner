<?php

namespace App\Factory;

use App\DTO\InvoiceItemDTO;
use App\Enums\CalendarMonthsNumberEnum;
use App\Enums\InvoiceInstallmentsEnum;
use App\VO\InvoiceVO;

class InvoiceFactory
{
    public static function factoryInvoice(InvoiceItemDTO $expense, int $thisMonth): InvoiceVO
    {
        $installment = self::getInstallmentBaseArray();
        $totalValue = 0;
        foreach ($installment as $key => $value) {
            $installments = $expense->getInstallments();
            $totalValue = $expense->getValue() * $installments;
            $installments = self::normalizeInstallments($installments);
            $nextMonth = self::calculateMonthForInstallment($thisMonth, $key);
            if ($nextMonth != $expense->getNextInstallmentMonth()) {
                continue;
            }
            $installment[$key] = $expense->getValue();
            for ($remaining = $key; $remaining <= 5; $remaining++) {
                if (self::isLimitInstallment($remaining, $key, $installments)) {
                    break;
                }
                $installment[$remaining + 1] = $expense->getValue();
            }
        }
        return InvoiceVO::makeInvoice($expense, $installment, $totalValue);
    }

    protected static function getInstallmentBaseArray(): array
    {
        return [
            0 => null,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ];
    }

    protected static function normalizeInstallments(int $installments): int
    {
        return $installments == InvoiceInstallmentsEnum::FixedInstallments->value
            ? InvoiceInstallmentsEnum::MaxInstallments->value
            : $installments;
    }

    protected static function calculateMonthForInstallment(int $month, int $sum): int
    {
        $nextMonth = $month + $sum;
        $december = CalendarMonthsNumberEnum::December->value;
        if ($nextMonth > $december) {
            $nextMonth = $nextMonth - $december;
        }
        return $nextMonth;
    }

    protected static function isLimitInstallment(int $remaining, int $key, int $installments): bool
    {
        return ($remaining - $key) + 1 == $installments;
    }
}
