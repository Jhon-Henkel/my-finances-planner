<?php

namespace App\Modules\Old\Movements\UseCase\DeleteTransfer;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Old\Wallet\UseCase\UpdateWalletByMovement\UpdateWalletByMovementUseCase;

class MovementTransferDeleteUseCase implements IDeleteUseCase
{
    public function __construct(protected UpdateWalletByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(int $id): void
    {
        /** @var  Movement|null $movement */
        $movement = Movement::find($id);
        if (! $movement || $movement->type != MovementTypeEnum::Transfer->value) {
            return;
        }
        if (str_contains($movement->description, 'Saída')) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, MovementTypeEnum::Gain->value);
        } elseif (str_contains($movement->description, 'Entrada')) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, MovementTypeEnum::Spent->value);
        }
        $movement->delete();
    }
}
