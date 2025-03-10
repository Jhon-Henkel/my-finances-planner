<?php

namespace App\Modules\Movements\UseCase\InsertTransfer;

use App\Enums\MovementEnum;
use App\Infra\Shared\UseCase\Insert\IInsertUseCase;
use App\Models\MovementModel;
use App\Modules\Wallet\UseCase\UpdateWalletByMovement\UpdateWalletByMovementUseCase;

class MovementTransferInsertUseCase implements IInsertUseCase
{
    public function __construct(protected UpdateWalletByMovementUseCase $updateWalletByMovementUseCase)
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
        /** @var MovementModel $spent */
        $spent = MovementModel::create([
            'description' => 'Saída transferência',
            'type' => MovementEnum::Transfer->value,
            'wallet_id' => $data['originId'],
            'amount' => $data['amount'],
        ]);
        $this->updateWalletByMovementUseCase->execute($spent->wallet_id, $spent->amount, MovementEnum::Spent->value);
    }

    protected function insertGain(array $data): void
    {
        /** @var MovementModel $gain */
        $gain = MovementModel::create([
            'description' => 'Entrada transferência',
            'type' => MovementEnum::Transfer->value,
            'wallet_id' => $data['destinationId'],
            'amount' => $data['amount'],
        ]);
        $this->updateWalletByMovementUseCase->execute($gain->wallet_id, $gain->amount, MovementEnum::Gain->value);
    }
}
