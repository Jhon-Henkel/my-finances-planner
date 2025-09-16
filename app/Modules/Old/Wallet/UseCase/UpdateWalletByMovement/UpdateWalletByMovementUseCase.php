<?php

namespace App\Modules\Old\Wallet\UseCase\UpdateWalletByMovement;

use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;

class UpdateWalletByMovementUseCase
{
    public function execute(int $walletId, float $amount, int $type): void
    {
        $wallet = Wallet::query()->findOrFail($walletId);
        if (MovementTypeEnum::isGain($type)) {
            $wallet->amount += $amount;
        } elseif (MovementTypeEnum::isSpent($type)) {
            $wallet->amount -= $amount;
        }
        $wallet->save();
    }
}
