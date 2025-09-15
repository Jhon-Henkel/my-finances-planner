<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Models\Wallet\Wallet;

class WalletUpdateUseCase implements IUpdateUseCase
{
    public function execute(array $data, int $id): array
    {
        $item = Wallet::findOrFail($id);

        $item->update([
            'hide_value' => $data['hideValue'],
            'name' => $data['name'],
            'status' => $data['status'],
            'amount' => $data['amount'],
        ]);

        return $item->toArray();
    }
}
