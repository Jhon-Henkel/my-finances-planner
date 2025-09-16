<?php

namespace App\Modules\Old\Movements\UseCase\Delete;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementUseCase;

class MovementDeleteUseCase implements IDeleteUseCase
{
    public function __construct(protected WalletUpdateByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(int $id): void
    {
        $movement = Movement::query()->find($id);
        if (! $movement) {
            return;
        }
        $type = MovementTypeEnum::isGain($movement->type) ? MovementTypeEnum::Spent : MovementTypeEnum::Gain;
        $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, $type->value);
        $movement->delete();
    }
}
