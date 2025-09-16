<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementTypeUseCase;
use InvalidArgumentException;

class MovementDeleteUseCase implements IDeleteUseCase
{
    public function __construct(protected WalletUpdateByMovementTypeUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(int $id): void
    {
        $movement = Movement::query()->findOrFail($id);

        if (MovementTypeEnum::isTransfer($movement->type)) {
            throw new InvalidArgumentException('Transfer movement cannot be deleted by this endpoint');
        }

        if (MovementTypeEnum::isGain($movement->type)) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, MovementTypeEnum::Spent->value);
        } elseif (MovementTypeEnum::isSpent($movement->type)) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, MovementTypeEnum::Gain->value);
        }

        $movement->delete();
    }
}
