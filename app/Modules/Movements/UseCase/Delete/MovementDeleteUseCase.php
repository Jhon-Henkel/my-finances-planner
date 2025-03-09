<?php

namespace App\Modules\Movements\UseCase\Delete;

use App\Enums\MovementEnum;
use App\Infra\Shared\UseCase\Delete\IDeleteUseCase;
use App\Models\MovementModel;
use App\Models\WalletModel;

class MovementDeleteUseCase implements IDeleteUseCase
{
    public function execute(int $id): void
    {
        $movement = MovementModel::query()->find($id);
        if (! $movement) {
            return;
        }
        $type = MovementEnum::isGain($movement->type) ? MovementEnum::Spent : MovementEnum::Gain;
        $this->updateWalletAmount($movement->wallet_id, $movement->amount, $type);
        $movement->delete();
    }

    protected function updateWalletAmount(int $walletId, float $amount, MovementEnum $type): void
    {
        $wallet = WalletModel::query()->findOrFail($walletId);
        if (MovementEnum::isGain($type->value)) {
            $wallet->amount += $amount;
        } elseif (MovementEnum::isSpent($type->value)) {
            $wallet->amount -= $amount;
        }
        $wallet->save();
    }
}
