<?php

namespace App\Modules\CreditCardTransaction\UseCase\Sum;

use App\Models\CreditCardTransaction;
use App\Modules\Invoice\Service\InvoiceListService;
use App\Tools\NumberTools;

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
        foreach ($allInvoiceItems as $invoiceItem) {
            if ($this->invoiceService->creditCardTransactionItemBelongsToInvoice($invoiceItem->toArray(), $queryParams)) {
                $sum += $invoiceItem->value;
            }
        }
        return NumberTools::roundFloatAmount($sum);
    }
}
