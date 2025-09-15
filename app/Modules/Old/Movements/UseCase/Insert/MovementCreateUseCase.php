<?php

namespace App\Modules\Old\Movements\UseCase\Insert;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\MovementModel;
use App\Modules\Old\Wallet\UseCase\UpdateWalletByMovement\UpdateWalletByMovementUseCase;

class MovementCreateUseCase implements ICreateUseCase
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
