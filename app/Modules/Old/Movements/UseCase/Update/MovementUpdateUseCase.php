<?php

namespace App\Modules\Old\Movements\UseCase\Update;

use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Old\Movements\Exceptions\MovementTypeDontIdentifiedException;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementUseCase;
use App\Tools\NumberTools;

class MovementUpdateUseCase implements IUpdateUseCase
{
    public function __construct(protected WalletUpdateByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(array $data, int $id): bool
    {
        $movement = Movement::query()->findOrFail($id);
        if ($movement->amount != $data['amount']) {
            $type = $this->getTypeForMovementUpdate($movement, $data);
            if (MovementTypeEnum::isGain($type->value)) {
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

    protected function getTypeForMovementUpdate(Movement $movement, array $data): MovementTypeEnum
    {
        if (MovementTypeEnum::isGain($movement->type) && $movement->amount > $data['amount']) {
            return MovementTypeEnum::Spent;
        } elseif (MovementTypeEnum::isGain($movement->type) && $movement->amount < $data['amount']) {
            return MovementTypeEnum::Gain;
        } elseif (MovementTypeEnum::isSpent($movement->type) && $movement->amount > $data['amount']) {
            return MovementTypeEnum::Gain;
        } elseif (MovementTypeEnum::isSpent($movement->type) && $movement->amount < $data['amount']) {
            return MovementTypeEnum::Spent;
        }
        throw new MovementTypeDontIdentifiedException();
    }
}
