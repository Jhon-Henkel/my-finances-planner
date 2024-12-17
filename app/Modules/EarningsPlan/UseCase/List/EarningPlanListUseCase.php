<?php

namespace App\Modules\EarningsPlan\UseCase\List;

use App\Enums\CalendarMonthsNumberEnum;
use App\Enums\RouteEnum;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Models\FutureGain;
use App\Tools\NumberTools;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EarningPlanListUseCase implements IListUseCase
{
    public function execute(int $perPage, int $page, array|null $queryParams = null): array
    {
        $this->validateQueryParams($queryParams);
        $result = $this->getList(999999, $page, $queryParams);
        $result['next_page_url'] = $this->makeNextMonthUrl($queryParams);
        $result['prev_page_url'] = $this->makePrevMonthUrl($queryParams);
        $result['meta']['total_month_amount'] = $this->sumTotalAmount($result['data']);
        $result['meta']['date_label'] = $this->getDateLabel($queryParams);
        $result['meta']['search_date'] = Date::createFromDate($queryParams['year'], $queryParams['month']);
        return $result;
    }

    protected function validateQueryParams(array|null &$queryParams): void
    {
        if (is_null($queryParams) || ! isset($queryParams['month'])) {
            $queryParams['month'] = Date::now()->month;
        }
        if (! isset($queryParams['year'])) {
            $queryParams['year'] = Date::now()->year;
        }
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
                $query->where('installments', '=', 0)
                    ->where('forecast', '<=', $startOfMonth);
            })
            ->orWhere(function ($query) use ($queryParams) {
                $query->where('installments', '=', 0)
                    ->whereMonth('forecast', '=', $queryParams['month'])
                    ->whereYear('forecast', '=', $queryParams['year']);
            })
            ->orderByRaw('DAY(forecast)');

        return $query->paginate($perPage, ['*'], 'page', $page)->toArray();
    }

    protected function makeNextMonthUrl(array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->addMonth();
        return RequestTools::mountUrl(RouteEnum::ApiEarningPlanList, "?year=$date->year&month=$date->month");

    }

    protected function makePrevMonthUrl(array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->subMonth();
        return RequestTools::mountUrl(RouteEnum::ApiEarningPlanList, "?year=$date->year&month=$date->month");
    }

    protected function sumTotalAmount(array $items): float
    {
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['amount'];
        }
        return NumberTools::roundFloatAmount($totalAmount);
    }

    protected function getDateLabel(array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $month = CalendarMonthsNumberEnum::getMonthName($date->month);
        return "$month de $date->year";
    }
}
