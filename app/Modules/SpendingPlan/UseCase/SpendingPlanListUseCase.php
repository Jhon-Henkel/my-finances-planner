<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Models\SpendingPlan\SpendingPlan;

class SpendingPlanListUseCase implements IListUseCaseV2
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        return SpendingPlan::query()
            ->orderBy($orderBy, $orderByDirection)
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}
