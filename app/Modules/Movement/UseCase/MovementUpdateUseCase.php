<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use InvalidArgumentException;

class MovementUpdateUseCase implements IUpdateUseCase
{
    public function execute(array $data, int $id): array
    {
        $movement = Movement::query()->findOrFail($id);

        if (MovementTypeEnum::isTransfer($movement->type) || MovementTypeEnum::isTransfer($data['type'])) {
            throw new InvalidArgumentException('Transfer movement cannot be edited');
        }

        $wallet = Wallet::query()->findOrFail($movement->wallet_id);

        $oldEffect = MovementTypeEnum::isGain($movement->type) ? +$movement->amount : -$movement->amount;
        $newEffect = MovementTypeEnum::isGain($data['type']) ? +$data['amount'] : -$data['amount'];

        $wallet->amount += $newEffect - $oldEffect;
        $wallet->save();

        $movement->update([
            'description' => $data['description'],
            'type' => $data['type'],
            'amount' => $data['amount'],
        ]);

        return $movement->toArray();
    }
}
