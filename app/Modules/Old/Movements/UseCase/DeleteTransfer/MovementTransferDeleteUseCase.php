<?php

namespace App\Modules\Old\Movements\UseCase\DeleteTransfer;

use App\Enums\MovementEnum;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\MovementModel;
use App\Modules\Old\Wallet\UseCase\UpdateWalletByMovement\UpdateWalletByMovementUseCase;

class MovementTransferDeleteUseCase implements IDeleteUseCase
{
    public function __construct(protected UpdateWalletByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(int $id): void
    {
        /** @var  MovementModel|null $movement */
        $movement = MovementModel::find($id);
        if (! $movement || $movement->type != MovementEnum::Transfer->value) {
            return;
        }
        if (str_contains($movement->description, 'Saída')) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, MovementEnum::Gain->value);
        } elseif (str_contains($movement->description, 'Entrada')) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, MovementEnum::Spent->value);
        }
        $movement->delete();
    }
}
