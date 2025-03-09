<?php

namespace App\Modules\Movements\UseCase\Update;

use App\Enums\MovementEnum;
use App\Infra\Shared\UseCase\Update\IUpdateUseCase;
use App\Models\MovementModel;
use App\Modules\Movements\Exceptions\MovementTypeDontIdentifiedException;
use App\Modules\Wallet\UseCase\UpdateWalletByMovement\UpdateWalletByMovementUseCase;
use App\Tools\NumberTools;

class MovementUpdateUseCase implements IUpdateUseCase
{
    public function __construct(protected UpdateWalletByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

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
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, abs($newAmount), $type->value);
        } elseif ($movement->type != $data['type']) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $data['amount'], $data['type']);
        }
        return $movement->update([
            'description' => $data['description'],
            'type' => $data['type'],
            'wallet_id' => $data['walletId'],
            'amount' => $data['amount']
        ]);
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
