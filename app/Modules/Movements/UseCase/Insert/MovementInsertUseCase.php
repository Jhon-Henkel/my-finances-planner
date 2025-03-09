<?php

namespace App\Modules\Movements\UseCase\Insert;

use App\Enums\MovementEnum;
use App\Infra\Shared\UseCase\Insert\IInsertUseCase;
use App\Models\MovementModel;
use App\Models\WalletModel;

class MovementInsertUseCase implements IInsertUseCase
{
    public function execute(array $data): bool
    {
        $this->updateWalletAmount($data['walletId'], $data['amount'], $data['type']);
        return MovementModel::insert([
            'description' => $data['description'],
            'type' => $data['type'],
            'wallet_id' => $data['walletId'],
            'amount' => $data['amount'],
        ]);
    }

    protected function updateWalletAmount(int $walletId, float $amount, int $type): void
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
