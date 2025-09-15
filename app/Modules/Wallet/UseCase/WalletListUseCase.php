<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Models\Wallet\Wallet;

class WalletListUseCase implements IListUseCaseV2
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        return Wallet::query()
            ->orderBy($orderBy, $orderByDirection)
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}
