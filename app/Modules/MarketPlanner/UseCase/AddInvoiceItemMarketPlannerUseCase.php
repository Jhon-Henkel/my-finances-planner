<?php

namespace App\Modules\MarketPlanner\UseCase;

use App\Modules\Invoice\Service\InvoiceService;
use App\Modules\MarketPlanner\UseCase\ShowDetailsMarketPlanner\ShowDetailsMarketPlannerUseCase;
use App\Tools\NumberTools;
use Illuminate\Support\Facades\Date;

class AddInvoiceItemMarketPlannerUseCase
{
    public function __construct(
        protected ShowDetailsMarketPlannerUseCase $showDetailsMarketPlannerUseCase
    ) {
    }

    public function execute(array &$result, array $queryParams): void
    {
        $marketPlanner = $this->showDetailsMarketPlannerUseCase->execute(0);
        if (!$this->isAllowedToUseMarketPlannerInvoiceItem($marketPlanner, $queryParams)) {
            return;
        }
        $value = $marketPlanner['total_limit'];
        if (Date::now()->month == $queryParams['month']) {
            $value = $marketPlanner['this_month_remaining_limit'];
        }
        if ($value <= 0) {
            return;
        }
        $result['data'][] = [
            "id" => InvoiceService::FIX_INSTALLMENT,
            "wallet_id" => InvoiceService::FIX_INSTALLMENT,
            "description" => "Mercado",
            "amount" => NumberTools::roundFloatAmount($value),
            "installments" => InvoiceService::FIX_INSTALLMENT,
            "forecast" => Date::now()->endOfMonth()->toDateTimeString(),
            "created_at" => Date::now()->toDateTimeString(),
            "updated_at" => Date::now()->toDateTimeString()
        ];
        $result['total']++;
    }

    protected function isAllowedToUseMarketPlannerInvoiceItem(array $marketPlanner, array $queryParams): bool
    {
        if (!$marketPlanner['use_market_planner']) {
            return false;
        }
        if ($queryParams['month'] < Date::now()->month && $queryParams['year'] <= Date::now()->year) {
            return false;
        }
        return true;
    }
}
