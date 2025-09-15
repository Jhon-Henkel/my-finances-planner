<?php

namespace App\Modules\CreditCard\UseCase;

use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Models\CreditCard\CreditCard;

class CreditCardListUseCase implements IListUseCaseV2
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        return CreditCard::query()
            ->orderBy($orderBy, $orderByDirection)
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}
