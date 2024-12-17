<?php

namespace App\Modules\Invoice\Service;

use App\Enums\CalendarMonthsNumberEnum;
use App\Enums\RouteEnum;
use App\Tools\NumberTools;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Date;

class InvoiceService
{
    public const int FIX_INSTALLMENT = 0;

    protected function makeInvoiceNextMonthUrl(RouteEnum $route, array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->addMonth();
        return RequestTools::mountUrl($route, "?year=$date->year&month=$date->month");

    }

    protected function makeInvoicePrevMonthUrl(RouteEnum $route, array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->subMonth();
        return RequestTools::mountUrl($route, "?year=$date->year&month=$date->month");
    }

    protected function getDateLabel(array $queryParams): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $month = CalendarMonthsNumberEnum::getMonthName($date->month);
        return "$month de $date->year";
    }

    protected function sumTotalAmount(array $items): float
    {
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['amount'];
        }
        return NumberTools::roundFloatAmount($totalAmount);
    }

    public function validateFilterDateQueryParams(array|null &$queryParams): void
    {
        if (is_null($queryParams) || ! isset($queryParams['month'])) {
            $queryParams['month'] = Date::now()->month;
        }
        if (! isset($queryParams['year'])) {
            $queryParams['year'] = Date::now()->year;
        }
    }

    public function addMetaData(array &$result, array $queryParams): void
    {
        $result['meta']['total_month_amount'] = $this->sumTotalAmount($result['data']);
        $result['meta']['date_label'] = $this->getDateLabel($queryParams);
        $result['meta']['search_date'] = Date::createFromDate($queryParams['year'], $queryParams['month']);
    }

    public function addPaginationUrls(array &$result, RouteEnum $route, array $queryParams): void
    {
        $result['next_page_url'] = $this->makeInvoiceNextMonthUrl($route, $queryParams);
        $result['prev_page_url'] = $this->makeInvoicePrevMonthUrl($route, $queryParams);
    }
}
