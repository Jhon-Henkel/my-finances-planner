<?php

namespace App\Modules\CreditCardTransaction\UseCase\Sum;

use App\Enums\InvoiceInstallmentsEnum;
use App\Models\CreditCard;
use App\Models\CreditCardTransaction;
use App\Modules\Invoice\Service\InvoiceListService;
use App\Tools\NumberTools;
use Illuminate\Support\Facades\Date;

class CreditCardTransactionSumUseCase
{
    public function __construct(protected InvoiceListService $invoiceService)
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
            $invoiceStart = Date::createFromDate($queryParams['year'], $queryParams['month'], 1)->startOfDay();
            // Está adicionando um mês, pois esse campo é a data da "compra" e não da fatura
            $itemNextInstallment = Date::createFromDate($invoiceItem->next_installment)->addMonth()->startOfDay();
            if ($invoiceItem->installments === InvoiceInstallmentsEnum::FixedInstallments->value) {
                if (
                    $itemNextInstallment->lessThan($invoiceStart)
                    || (
                        $itemNextInstallment->month === $invoiceStart->month
                        && $itemNextInstallment->year === $invoiceStart->year
                    )
                ) {
                    $sum += $invoiceItem->value;
                }
                continue;
            }
            $invoiceEnd = $invoiceStart->copy()->addMonth()->subDay()->endOfDay();
            $itemLastInstallment = $itemNextInstallment->copy()->addMonths($invoiceItem->installments - 1)->subDay()->endOfDay();
            if (
                (
                    $itemNextInstallment->greaterThanOrEqualTo($invoiceStart)
                    && $itemNextInstallment->lessThanOrEqualTo($invoiceEnd)
                ) || (
                    $itemNextInstallment->lessThanOrEqualTo($invoiceEnd)
                    && $itemLastInstallment->greaterThanOrEqualTo($invoiceStart)
                )
            ) {
                $sum += $invoiceItem->value;
            }
        }
        return NumberTools::roundFloatAmount($sum);
    }
}
