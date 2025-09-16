<?php

namespace App\Modules\EarningPlan\UseCase;

use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Models\EarningPlan\EarningPlan;

class EarningPlanListUseCase implements IListUseCaseV2
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        return EarningPlan::query()
            ->orderBy($orderBy, $orderByDirection)
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}
