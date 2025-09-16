<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementUseCase;

class MovementTransferCreateUseCase implements ICreateUseCaseV2
{
    public function __construct(private WalletUpdateByMovementUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(array $data): array
    {
        $originId = $data['originWalletId'];
        $destId = $data['destinationWalletId'];
        $amount = $data['amount'];
        $desc = 'Transferência';

        $this->updateWalletByMovementUseCase->execute($originId, $amount, MovementTypeEnum::Spent->value);
        $this->updateWalletByMovementUseCase->execute($destId, $amount, MovementTypeEnum::Gain->value);

        Movement::insert([
            'description' => $desc . ' - saída',
            'type' => MovementTypeEnum::Transfer->value,
            'wallet_id' => $originId,
            'amount' => $amount,
        ]);

        Movement::insert([
            'description' => $desc . ' - entrada',
            'type' => MovementTypeEnum::Transfer->value,
            'wallet_id' => $destId,
            'amount' => $amount,
        ]);

        return [];
    }
}
