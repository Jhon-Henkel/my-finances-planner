<?php

namespace App\Modules\Old\Movements\UseCase\InsertTransfer;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\WalletUpdateByMovementTypeUseCase;

class MovementTransferCreateUseCase implements ICreateUseCase
{
    public function __construct(protected WalletUpdateByMovementTypeUseCase $updateWalletByMovementUseCase)
    {
    }

    public function execute(array $data): bool
    {
        $this->insertSpent($data);
        $this->insertGain($data);
        return  true;
    }

    protected function insertSpent(array $data): void
    {
        /** @var Movement $spent */
        $spent = Movement::create([
            'description' => 'Saída transferência',
            'type' => MovementTypeEnum::Transfer->value,
            'wallet_id' => $data['originId'],
            'amount' => $data['amount'],
        ]);
        $this->updateWalletByMovementUseCase->execute($spent->wallet_id, $spent->amount, MovementTypeEnum::Spent->value);
    }

    protected function insertGain(array $data): void
    {
        /** @var Movement $gain */
        $gain = Movement::create([
            'description' => 'Entrada transferência',
            'type' => MovementTypeEnum::Transfer->value,
            'wallet_id' => $data['destinationId'],
            'amount' => $data['amount'],
        ]);
        $this->updateWalletByMovementUseCase->execute($gain->wallet_id, $gain->amount, MovementTypeEnum::Gain->value);
    }
}
