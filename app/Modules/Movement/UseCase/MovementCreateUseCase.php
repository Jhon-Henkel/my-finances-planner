<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Movement\Movement;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementTypeUseCase;

class MovementCreateUseCase implements ICreateUseCase
{
    public function __construct(private WalletUpdateByMovementTypeUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(array $data): array
    {
        $this->updateWalletByMovementUseCase->execute($data['walletId'], $data['amount'], $data['type']);
        Movement::insert([
            'description' => $data['description'],
            'type' => $data['type'],
            'wallet_id' => $data['walletId'],
            'amount' => $data['amount'],
        ]);
        return [];
    }
}
