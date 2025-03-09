<?php

namespace App\Modules\Movements\UseCase\Insert;

use App\Infra\Shared\UseCase\Insert\IInsertUseCase;
use App\Models\MovementModel;
use App\Modules\Wallet\UseCase\UpdateWalletByMovement\UpdateWalletByMovementUseCase;

class MovementInsertUseCase implements IInsertUseCase
{
    public function __construct(protected UpdateWalletByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(array $data): bool
    {
        $this->updateWalletByMovementUseCase->execute($data['walletId'], $data['amount'], $data['type']);
        return MovementModel::insert([
            'description' => $data['description'],
            'type' => $data['type'],
            'wallet_id' => $data['walletId'],
            'amount' => $data['amount'],
        ]);
    }
}
