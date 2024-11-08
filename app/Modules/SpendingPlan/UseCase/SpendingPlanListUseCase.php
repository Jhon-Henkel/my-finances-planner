<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Enums\RouteEnum;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Modules\SpendingPlan\Domain\SpendingPlanModel;
use App\Modules\SpendingPlan\Exceptions\MonthQueryParamMissingException;
use App\Modules\SpendingPlan\Exceptions\YearQueryParamMissingException;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SpendingPlanListUseCase implements IListUseCase
{
    public function execute(int $perPage, int $page, array|null $queryParams = null): array
    {
        $perPage = 999999;
        $this->validateQueryParams($queryParams);
        $result = $this->getList($perPage, $page, $queryParams);
        $result['next_page_url'] = $this->makeNextMonthUrl($queryParams);
        $result['prev_page_url'] = $this->makePrevMonthUrl($queryParams);
        return $result;
    }

    protected function validateQueryParams(array|null $queryParams): void
    {
        if (is_null($queryParams) || ! isset($queryParams['month'])) {
            throw new MonthQueryParamMissingException();
        }
        if (! isset($queryParams['year'])) {
            throw new YearQueryParamMissingException();
        }
    }

    protected function getList(int $perPage, int $page, array $queryParams): array
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $startOfMonth = "{$date->copy()->startOfMonth()->toDateString()} 00:00:00";
        $endOfMonth = "{$date->copy()->endOfMonth()->toDateString()} 23:59:59";

        $query = SpendingPlanModel::query();
        $query->select('*')
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where('installments', '>', 0)
                    ->where('forecast', '<=', $endOfMonth)
                    ->where(DB::raw('DATE_ADD(forecast, INTERVAL (installments - 1) MONTH)'), '>=', $startOfMonth);
            })
            ->orWhere(function ($query) use ($startOfMonth) {
                $query->where('installments', '=', 0)
                    ->where('forecast', '<=', $startOfMonth);
            })
            ->join('wallets', 'future_spent.wallet_id', '=', 'wallets.id')
            ->orderByRaw('DAY(forecast)');

        return $query->paginate($perPage, ['*'], 'page', $page)->toArray();
    }

    protected function makeNextMonthUrl(array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->addMonth();
        return route(RouteEnum::ApiSpendingPlanList) . "?year=$date->year&month=$date->month";
    }

    protected function makePrevMonthUrl(array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->subMonth();
        return route(RouteEnum::ApiSpendingPlanList) . "?year=$date->year&month=$date->month";
    }
}
