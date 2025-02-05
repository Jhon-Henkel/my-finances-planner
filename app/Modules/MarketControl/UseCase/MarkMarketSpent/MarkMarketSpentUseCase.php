<?php

namespace App\Modules\MarketControl\UseCase\MarkMarketSpent;

use App\Enums\MovementEnum;
use App\Models\MovementModel;
use App\Services\Database\DatabaseConnectionService;

readonly class MarkMarketSpentUseCase
{
    public function __construct(private DatabaseConnectionService $databaseConnectionService)
    {
    }

    public function execute(array $data): array
    {
        $isValid = $this->isValidData($data);
        if (!$isValid) {
            $this->databaseConnectionService->setMasterConnection();
            return ['status' => 'error'];
        }
        $this->databaseConnectionService->connectTenantByTenantHash(config('app.market_control_hash'));
        MovementModel::create([
            'wallet_id' => $data['wallet_id'],
            'description' => 'Mercado',
            'type' => MovementEnum::Spent->value,
            'amount' => $data['amount']
        ]);

        $this->databaseConnectionService->setMasterConnection();
        return ['status' => 'ok'];
    }

    protected function isValidData(array $array): bool
    {
        return isset($array['wallet_id']) && isset($array['amount']);
    }
}
