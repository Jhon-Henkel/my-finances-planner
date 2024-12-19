<?php

namespace App\Modules\Invoice\Service;

use App\Enums\CalendarMonthsNumberEnum;
use App\Enums\InvoiceInstallmentsEnum;
use App\Enums\RouteEnum;
use App\Tools\NumberTools;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Date;

class InvoiceListService
{
    public const int FIX_INSTALLMENT = 0;

    protected function makeInvoiceNextMonthUrl(RouteEnum $route, array $queryParams, array $args = []): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->addMonth();
        return RequestTools::mountUrl($route, "?year=$date->year&month=$date->month", $args);

    }

    protected function makeInvoicePrevMonthUrl(RouteEnum $route, array $queryParams, array $args = []): string
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $date->subMonth();
        return RequestTools::mountUrl($route, "?year=$date->year&month=$date->month", $args);
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

    public function addMetaData(array &$result, array $queryParams): void
    {
        $result['meta']['total_month_amount'] = $this->sumTotalAmount($result['data']);
        $result['meta']['date_label'] = $this->getDateLabel($queryParams);
        $result['meta']['search_date'] = Date::createFromDate($queryParams['year'], $queryParams['month']);
    }

    public function addPaginationUrls(array &$result, RouteEnum $route, array $queryParams, array $args = []): void
    {
        $result['next_page_url'] = $this->makeInvoiceNextMonthUrl($route, $queryParams, $args);
        $result['prev_page_url'] = $this->makeInvoicePrevMonthUrl($route, $queryParams, $args);
    }

    public function creditCardTransactionItemBelongsToInvoice(array $invoiceItem, array $queryParams): bool
    {
        $invoiceStart = Date::createFromDate($queryParams['year'], $queryParams['month'], 1)->startOfDay();
        // Está adicionando um mês, pois esse campo é a data da "compra" e não da fatura
        $itemNextInstallment = Date::createFromDate($invoiceItem['next_installment'])->addMonth()->startOfDay();
        if ($invoiceItem['installments'] === InvoiceInstallmentsEnum::FixedInstallments->value) {
            if (
                $itemNextInstallment->lessThan($invoiceStart)
                || (
                    $itemNextInstallment->month === $invoiceStart->month
                    && $itemNextInstallment->year === $invoiceStart->year
                )
            ) {
                return true;
            }
        }
        $invoiceEnd = $invoiceStart->copy()->addMonth()->subDay()->endOfDay();
        $itemLastInstallment = $itemNextInstallment->copy()->addMonths($invoiceItem['installments'] - 1)->subDay()->endOfDay();
        if (
            (
                $itemNextInstallment->greaterThanOrEqualTo($invoiceStart)
                && $itemNextInstallment->lessThanOrEqualTo($invoiceEnd)
            ) || (
                $itemNextInstallment->lessThanOrEqualTo($invoiceEnd)
                && $itemLastInstallment->greaterThanOrEqualTo($invoiceStart)
            )
        ) {
            return true;
        }
        return false;
    }
}
