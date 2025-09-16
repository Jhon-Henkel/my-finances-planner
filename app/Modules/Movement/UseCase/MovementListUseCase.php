<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Models\Movement\Movement;

class MovementListUseCase implements IListUseCaseV2
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        return Movement::query()
            ->orderBy($orderBy, $orderByDirection)
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}
