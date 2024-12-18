<?php

namespace App\Modules\CreditCardTransaction\UseCase\Sum;

use App\Enums\InvoiceInstallmentsEnum;
use App\Models\CreditCard;
use App\Models\CreditCardTransaction;
use App\Modules\Invoice\Service\InvoiceService;
use App\Tools\NumberTools;
use Illuminate\Support\Facades\Date;

class CreditCardTransactionSumUseCase
{
    public function __construct(protected InvoiceService $invoiceService)
    {
    }

    public function execute(array|null $queryParams = null): float
    {
        $this->invoiceService->validateFilterDateQueryParams($queryParams);
        return $this->getSum($queryParams);
    }

    protected function getSum(array $queryParams): float
    {
        $allInvoiceItems = CreditCardTransaction::all();
        $sum = 0;
        $creditCardsIds = $allInvoiceItems->pluck('credit_card_id')->unique()->toArray();
        $creditCards = [];
        foreach (CreditCard::whereIn('id', $creditCardsIds)->get() as $creditCard) {
            $creditCards[$creditCard->id] = $creditCard;
        }
        foreach ($allInvoiceItems as $invoiceItem) {
            $creditCard = $creditCards[$invoiceItem->credit_card_id];
            $invoiceStart = Date::createFromDate($queryParams['year'], $queryParams['month'], $creditCard->closing_day);
            $invoiceEnd = $invoiceStart->copy()->addMonth();
            $itemNextInstallment = Date::createFromDate($invoiceItem->next_installment);
            if ($invoiceItem->installments === InvoiceInstallmentsEnum::FixedInstallments->value) {
                if (
                    $itemNextInstallment->lessThanOrEqualTo($invoiceStart)
                    || (
                        $itemNextInstallment->day >= $creditCard->closing_day
                        && $itemNextInstallment->month === $invoiceStart->month
                        && $itemNextInstallment->year === $invoiceStart->year
                    )
                ) {
                    $sum += $invoiceItem->value;
                }
                continue;
            }
            $itemLastInstallment = Date::createFromDate($invoiceItem->next_installment)->addMonths($invoiceItem->installments - 1);
            if (
                $itemNextInstallment->lessThanOrEqualTo($invoiceEnd)
                && $itemLastInstallment->greaterThanOrEqualTo($invoiceStart)
            ) {
                $sum += $invoiceItem->value;
            }
        }
        return NumberTools::roundFloatAmount($sum);
    }
}
