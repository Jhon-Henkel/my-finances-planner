<?php

namespace App\Modules\Movements\UseCase\List;

use App\Enums\MovementEnum;
use App\Enums\RouteEnum;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Models\MovementModel;
use App\Tools\Calendar\CalendarTools;
use App\Tools\NumberTools;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Date;

class MovementListUseCase implements IListUseCase
{
    public function execute(int $perPage, int $page, ?array $queryParams = null): array
    {
        $this->validateFilterDateQueryParams($queryParams);
        $result = $this->getList($perPage, $page, $queryParams);
        $result['next_page_url'] = $this->makeInvoiceNextMonthUrl($queryParams, $queryParams);
        $result['prev_page_url'] = $this->makeInvoicePrevMonthUrl($queryParams, $queryParams);
        $this->addMetaData($result, $queryParams);
        return $result;
    }

    protected function validateFilterDateQueryParams(array|null &$queryParams): void
    {
        if (is_null($queryParams)) {
            $queryParams = [];
        }
        if (! isset($queryParams['month'])) {
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

        $result = MovementModel::query()
            ->select(
                'movements.id',
                'movements.wallet_id as walletId',
                'movements.description',
                'movements.type',
                'movements.amount',
                'movements.created_at as createdAt',
                'movements.updated_at as updatedAt',
                'wallets.name as walletName'
            )
            ->where('movements.created_at', '>=', $startOfMonth)
            ->where('movements.created_at', '<=', $endOfMonth);
        if (isset($queryParams['type']) && $queryParams['type'] != 0) {
            $result->where('movements.type', '=', $queryParams['type']);
        }
        return $result->join('wallets', 'movements.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page)->toArray();
    }

    protected function makeInvoiceNextMonthUrl(array $queryParams, array $args = []): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month'], 1);
        $date->addMonth();
        return RequestTools::mountUrl(RouteEnum::ApiMovementList, "?year=$date->year&month=$date->month", $args);
    }

    protected function makeInvoicePrevMonthUrl(array $queryParams, array $args = []): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month'], 1);
        $date->subMonth();
        return RequestTools::mountUrl(RouteEnum::ApiMovementList, "?year=$date->year&month=$date->month", $args);
    }

    public function addMetaData(array &$result, array $queryParams): void
    {
        $result['meta']['total_month_gain'] = $this->sumTotalGain($result['data']);
        $result['meta']['total_month_spent'] = $this->sumTotalSpent($result['data']);
        $result['meta']['total_month'] = NumberTools::roundFloatAmount($result['meta']['total_month_gain'] - $result['meta']['total_month_spent']);
        $result['meta']['date_label'] = CalendarTools::getDateLabelByQueryParams($queryParams);
        $result['meta']['search_date'] = Date::createFromDate($queryParams['year'], $queryParams['month']);
    }

    protected function sumTotalGain(array $items): float
    {
        $totalAmount = 0;
        foreach ($items as $item) {
            if (MovementEnum::isGain($item['type'])) {
                $totalAmount += $item['amount'];
            }
        }
        return NumberTools::roundFloatAmount($totalAmount);
    }

    protected function sumTotalSpent(array $items): float
    {
        $totalAmount = 0;
        foreach ($items as $item) {
            if (MovementEnum::isSpent($item['type'])) {
                $totalAmount += $item['amount'];
            }
        }
        return NumberTools::roundFloatAmount($totalAmount);
    }
}
