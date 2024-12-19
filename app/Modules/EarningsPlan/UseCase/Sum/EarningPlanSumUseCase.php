<?php

namespace App\Modules\EarningsPlan\UseCase\Sum;

use App\Models\FutureGain;
use App\Modules\Invoice\Service\InvoiceListService;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EarningPlanSumUseCase
{
    public function __construct(protected InvoiceListService $invoiceService)
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
        $startOfMonth = "{$date->copy()->startOfMonth()->toDateString()} 00:00:00";
        $endOfMonth = "{$date->copy()->endOfMonth()->toDateString()} 23:59:59";
        return FutureGain::query()
            ->select('*')
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where('installments', '>', 0)
                    ->where('forecast', '<=', $endOfMonth)
                    ->where(DB::raw('DATE_ADD(forecast, INTERVAL (installments - 1) MONTH)'), '>=', $startOfMonth);
            })
            ->orWhere(function ($query) use ($startOfMonth) {
                $query->where('installments', '=', InvoiceListService::FIX_INSTALLMENT)
                    ->where('forecast', '<=', $startOfMonth);
            })
            ->orWhere(function ($query) use ($queryParams) {
                $query->where('installments', '=', InvoiceListService::FIX_INSTALLMENT)
                    ->whereMonth('forecast', '=', $queryParams['month'])
                    ->whereYear('forecast', '=', $queryParams['year']);
            })
            ->sum('amount');
    }
}
