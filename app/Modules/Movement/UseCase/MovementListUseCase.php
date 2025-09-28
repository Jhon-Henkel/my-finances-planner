<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Read\IListUseCase;
use App\Models\Movement\Movement;

class MovementListUseCase implements IListUseCase
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        return Movement::query()
            ->orderBy($orderBy, $orderByDirection)
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}
