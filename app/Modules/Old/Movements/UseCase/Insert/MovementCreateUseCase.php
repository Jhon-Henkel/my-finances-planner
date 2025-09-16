<?php

namespace App\Modules\Old\Movements\UseCase\Insert;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Movement\Movement;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementTypeUseCase;

class MovementCreateUseCase implements ICreateUseCase
{
    public function __construct(protected WalletUpdateByMovementTypeUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(array $data): bool
    {
        $this->updateWalletByMovementUseCase->execute($data['walletId'], $data['amount'], $data['type']);
        return Movement::insert([
            'description' => $data['description'],
            'type' => $data['type'],
            'wallet_id' => $data['walletId'],
            'amount' => $data['amount'],
        ]);
    }
}
