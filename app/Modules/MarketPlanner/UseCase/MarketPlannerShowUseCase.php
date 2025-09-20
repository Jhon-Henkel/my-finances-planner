<?php

namespace App\Modules\MarketPlanner\UseCase;

use App\Services\Tools\MarketPlannerService;

class MarketPlannerShowUseCase
{
    public function __construct(private readonly MarketPlannerService $marketPlannerService)
    {
    }

    public function execute(): array
    {
        $totalLimit = $this->marketPlannerService->getMarketPlannerValue();
        $remainingLimit = $this->marketPlannerService->getMarketPlannerInvoice()->firstInstallment;
        return [
            'use_market_planner' => $this->marketPlannerService->useMarketPlanner(),
            'total_limit' => $totalLimit,
            'this_month_spent' => $this->marketPlannerService->getThisMonthMarketSpentValue(),
            'this_month_remaining_limit' => $remainingLimit,
        ];
    }
}
