<?php

namespace App\Modules\MarketControl\UseCase\MarkMarketSpent;

use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Movement\MovementService;

readonly class MarkMarketSpentUseCase
{
    public function __construct(
        private DatabaseConnectionService $databaseConnectionService,
        private MovementService $movementService
    ) {
    }

    public function execute(array $data): array
    {
        $isValid = $this->isValidData($data);
        if (!$isValid) {
            $this->databaseConnectionService->setMasterConnection();
            return ['status' => 'error'];
        }
        $this->databaseConnectionService->connectTenantByTenantHash(config('app.market_control_hash'));

        $data = new MovementDTO();
        $data->setWalletId($data['wallet_id']);
        $data->setAmount($data['amount']);
        $data->setDescription('Mercado');
        $data->setType(MovementEnum::Spent->value);

        $this->movementService->insert($data);

        $this->databaseConnectionService->setMasterConnection();
        return ['status' => 'ok'];
    }

    protected function isValidData(array $array): bool
    {
        return isset($array['wallet_id']) && isset($array['amount']);
    }
}
