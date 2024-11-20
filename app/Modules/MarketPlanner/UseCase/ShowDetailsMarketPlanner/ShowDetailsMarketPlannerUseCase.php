<?php

namespace App\Modules\MarketPlanner\UseCase\ShowDetailsMarketPlanner;

use App\Infra\Shared\UseCase\Show\IShowUseCase;
use App\Services\Tools\MarketPlannerService;

class ShowDetailsMarketPlannerUseCase implements IShowUseCase
{
    public function __construct(protected MarketPlannerService $marketPlannerService)
    {
    }

    public function execute(int $id): array
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
