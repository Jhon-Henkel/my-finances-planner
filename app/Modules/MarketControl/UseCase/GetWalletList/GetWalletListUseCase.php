<?php

namespace App\Modules\MarketControl\UseCase\GetWalletList;

use App\Enums\StatusEnum;
use App\Models\WalletModel;
use App\Services\Database\DatabaseConnectionService;

readonly class GetWalletListUseCase
{
    public function __construct(private DatabaseConnectionService $databaseConnectionService)
    {
    }

    public function execute(): array
    {
        $this->databaseConnectionService->connectTenantByTenantHash(config('app.market_control_hash'));
        $wallets = WalletModel::where('status', StatusEnum::Active->value)->get();
        $this->databaseConnectionService->setMasterConnection();
        return $wallets->toArray();
    }
}
