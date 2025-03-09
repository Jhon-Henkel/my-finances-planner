<?php

namespace App\Modules\Movements\UseCase\Delete;

use App\Enums\MovementEnum;
use App\Infra\Shared\UseCase\Delete\IDeleteUseCase;
use App\Models\MovementModel;
use App\Modules\Wallet\UseCase\UpdateWalletByMovement\UpdateWalletByMovementUseCase;

class MovementDeleteUseCase implements IDeleteUseCase
{
    public function __construct(protected UpdateWalletByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(int $id): void
    {
        $movement = MovementModel::query()->find($id);
        if (! $movement) {
            return;
        }
        $type = MovementEnum::isGain($movement->type) ? MovementEnum::Spent : MovementEnum::Gain;
        $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, $type->value);
        $movement->delete();
    }
}
