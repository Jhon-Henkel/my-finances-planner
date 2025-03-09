<?php

namespace App\Modules\Movements\UseCase\Update;

use App\Enums\MovementEnum;
use App\Infra\Shared\UseCase\Update\IUpdateUseCase;
use App\Models\MovementModel;
use App\Models\WalletModel;
use App\Modules\Movements\Exceptions\MovementTypeDontIdentifiedException;
use App\Tools\NumberTools;

class MovementUpdateUseCase implements IUpdateUseCase
{
    public function execute(array $data, int $id): bool
    {
        $movement = MovementModel::query()->findOrFail($id);
        if ($movement->amount != $data['amount']) {
            $type = $this->getTypeForMovementUpdate($movement, $data);
            if (MovementEnum::isGain($type->value)) {
                $newAmount = NumberTools::roundFloatAmount($data['amount'] - $movement->amount);
            } else {
                $newAmount = NumberTools::roundFloatAmount($movement->amount - $data['amount']);
            }
            $this->updateWallet($movement->wallet_id, abs($newAmount), $type);
        } elseif ($movement->type != $data['type']) {
            $this->updateWallet($movement->wallet_id, $data['amount'], $data['type']);
        }
        return $movement->update([
            'description' => $data['description'],
            'type' => $data['type'],
            'wallet_id' => $data['walletId'],
            'amount' => $data['amount']
        ]);
    }

    protected function updateWallet(int $walletId, float $amount, MovementEnum $type): void
    {
        $wallet = WalletModel::query()->findOrFail($walletId);
        if (MovementEnum::isGain($type->value)) {
            $wallet->amount += $amount;
        } elseif (MovementEnum::isSpent($type->value)) {
            $wallet->amount -= $amount;
        }
        $wallet->save();
    }

    protected function getTypeForMovementUpdate(MovementModel $movement, array $data): MovementEnum
    {
        if (MovementEnum::isGain($movement->type) && $movement->amount > $data['amount']) {
            return MovementEnum::Spent;
        } elseif (MovementEnum::isGain($movement->type) && $movement->amount < $data['amount']) {
            return MovementEnum::Gain;
        } elseif (MovementEnum::isSpent($movement->type) && $movement->amount > $data['amount']) {
            return MovementEnum::Gain;
        } elseif (MovementEnum::isSpent($movement->type) && $movement->amount < $data['amount']) {
            return MovementEnum::Spent;
        }
        throw new MovementTypeDontIdentifiedException();
    }
}
