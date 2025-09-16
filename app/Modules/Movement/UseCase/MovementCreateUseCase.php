<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\Movement\Movement;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementUseCase;

class MovementCreateUseCase implements ICreateUseCaseV2
{
    public function __construct(private WalletUpdateByMovementUseCase $updateWalletByMovementUseCase)
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
