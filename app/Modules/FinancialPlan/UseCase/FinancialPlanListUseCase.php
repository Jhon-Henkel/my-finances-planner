<?php

namespace App\Modules\FinancialPlan\UseCase;

use App\Infra\UseCase\Read\IListUseCase;
use App\Models\FinancialPlan\FinancialPlan;

class FinancialPlanListUseCase implements IListUseCase
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        return FinancialPlan::with('installments_data')
            ->orderBy($orderBy, $orderByDirection)
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}
