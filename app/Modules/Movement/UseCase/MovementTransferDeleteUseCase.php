<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementUseCase;
use InvalidArgumentException;

class MovementTransferDeleteUseCase implements IDeleteUseCase
{
    public function __construct(protected WalletUpdateByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(int $id): void
    {
        $movement = Movement::query()->findOrFail($id);

        if (!MovementTypeEnum::isTransfer($movement->type)) {
            throw new InvalidArgumentException('Only transfer movements can be deleted by this endpoint');
        }

        if (str_contains($movement->description, 'saída')) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, MovementTypeEnum::Gain->value);
        } elseif (str_contains($movement->description, 'entrada')) {
            $this->updateWalletByMovementUseCase->execute($movement->wallet_id, $movement->amount, MovementTypeEnum::Spent->value);
        }

        $movement->delete();
    }
}
