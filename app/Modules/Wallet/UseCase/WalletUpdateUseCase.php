<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Models\Wallet\Wallet;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;

class WalletUpdateUseCase implements IUpdateUseCaseV2
{
    public function execute(array $data, int $id): array
    {
        $item = Wallet::findOrFail($id);

        $oldAmount = $item->amount;
        $newAmount = $data['amount'];

        $item->update([
            'hide_value' => $data['hideValue'],
            'name' => $data['name'],
            'status' => $data['status'],
            'amount' => $newAmount,
        ]);

        $this->insertMovement($item, $newAmount - $oldAmount);

        return $item->toArray();
    }

    protected function insertMovement(Wallet $item, float $diff): void
    {
        if ($diff != 0.0) {
            Movement::insert([
                'wallet_id' => $item->id,
                'description' => 'Atualização saldo carteira',
                'type' => $diff > 0 ? MovementTypeEnum::Gain->value : MovementTypeEnum::Spent->value,
                'amount' => abs($diff),
            ]);
        }
    }
}
