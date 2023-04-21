<?php

namespace App\Factory;

use App\DTO\InvoiceItemDTO;
use App\Enums\InvoiceEnum;
use App\VO\InvoiceVO;

class InvoiceFactory
{
    /**
     * @param InvoiceItemDTO $expense
     * @param int $thisMonth
     * @return InvoiceVO
     */
    public static function factoryInvoice(InvoiceItemDTO $expense, int $thisMonth): InvoiceVO
    {
        $installment = self::getInstallmentBaseArray();
        $totalValue = 0;
        foreach ($installment as $key => $value) {
            $installments = $expense->getInstallments();
            $totalValue = $expense->getValue() * $installments;
            $installments = $installments == InvoiceEnum::FIXED_INSTALLMENTS
                ? InvoiceEnum::MAX_INSTALLMENTS
                : $installments;
            if ($thisMonth + $key == $expense->getNextInstallmentMonth()) {
                $installment[$key] = $expense->getValue();
                for ($remaining = $key; $remaining <= 5; $remaining ++) {
                    if (($remaining - $key) + 1 == $installments) {
                        break;
                    }
                    $installment[$remaining + 1] = $expense->getValue();
                }
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
}