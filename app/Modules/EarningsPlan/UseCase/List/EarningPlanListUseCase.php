<?php

namespace App\Modules\EarningsPlan\UseCase\List;

use App\Enums\RouteEnum;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Models\FutureGain;
use App\Modules\Invoice\Service\InvoiceListService;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EarningPlanListUseCase implements IListUseCase
{
    public function __construct(protected InvoiceListService $invoiceService)
    {
    }

    public function execute(int $perPage, int $page, array|null $queryParams = null): array
    {
        $this->invoiceService->validateFilterDateQueryParams($queryParams);
        $result = $this->getList(999999, $page, $queryParams);
        $this->invoiceService->addPaginationUrls($result, RouteEnum::ApiEarningPlanList, $queryParams);
        $this->invoiceService->addMetaData($result, $queryParams);
        return $result;
    }

    protected function getList(int $perPage, int $page, array $queryParams): array
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $startOfMonth = "{$date->copy()->startOfMonth()->toDateString()} 00:00:00";
        $endOfMonth = "{$date->copy()->endOfMonth()->toDateString()} 23:59:59";
        $query = FutureGain::query()
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
            ->orderByRaw('DAY(forecast)');

        return $query->paginate($perPage, ['*'], 'page', $page)->toArray();
    }
}
