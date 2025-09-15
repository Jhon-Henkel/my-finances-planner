<?php

namespace App\Modules\Old\Wallet\UseCase\UpdateWalletByMovement;

use App\Enums\MovementEnum;
use App\Models\Wallet\Wallet;

class UpdateWalletByMovementUseCase
{
    public function execute(int $walletId, float $amount, int $type): void
    {
        $wallet = Wallet::query()->findOrFail($walletId);
        if (MovementEnum::isGain($type)) {
            $wallet->amount += $amount;
        } elseif (MovementEnum::isSpent($type)) {
            $wallet->amount -= $amount;
        }
        $wallet->save();
    }
}
