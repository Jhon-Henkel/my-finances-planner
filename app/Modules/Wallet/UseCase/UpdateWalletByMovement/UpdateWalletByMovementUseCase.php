<?php

namespace App\Modules\Wallet\UseCase\UpdateWalletByMovement;

use App\Enums\MovementEnum;
use App\Models\WalletModel;

class UpdateWalletByMovementUseCase
{
    public function execute(int $walletId, float $amount, int $type): void
    {
        $wallet = WalletModel::query()->findOrFail($walletId);
        if (MovementEnum::isGain($type)) {
            $wallet->amount += $amount;
        } elseif (MovementEnum::isSpent($type)) {
            $wallet->amount -= $amount;
        }
        $wallet->save();
    }
}
