<?php

namespace App\Modules\CreditCardTransaction\UseCase\Sum;

use App\Models\CreditCardTransaction;
use App\Modules\Invoice\Service\InvoiceService;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CreditCardTransactionSumUseCase
{
    public function __construct(protected InvoiceService $invoiceService)
    {
    }

    public function execute(array|null $queryParams = null): string
    {
        $this->invoiceService->validateFilterDateQueryParams($queryParams);
        return $this->getSum($queryParams);
    }

    protected function getSum(array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->subMonths();
        $startOfMonth = $date->copy()->startOfMonth()->toDateString();
        $endOfMonth = $date->copy()->endOfMonth()->toDateString();
        return CreditCardTransaction::query()
            ->select('*')
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where('installments', '>', 0)
                    ->where('next_installment', '<=', $endOfMonth)
                    ->where(DB::raw('DATE_ADD(next_installment, INTERVAL (installments - 1) MONTH)'), '>=', $startOfMonth);
            })
            ->orWhere(function ($query) use ($startOfMonth) {
                $query->where('installments', '=', InvoiceService::FIX_INSTALLMENT)
                    ->where('next_installment', '<=', $startOfMonth);
            })
            ->orWhere(function ($query) use ($date) {
                $query->where('installments', '=', InvoiceService::FIX_INSTALLMENT)
                    ->whereMonth('next_installment', '=', $date->month)
                    ->whereYear('next_installment', '=', $date->year);
            })
            ->sum('value');
    }
}
