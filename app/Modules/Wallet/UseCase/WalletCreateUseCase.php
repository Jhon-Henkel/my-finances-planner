<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Wallet\Wallet;

class WalletCreateUseCase implements ICreateUseCase
{
    public function execute(array $data): array
    {
        return Wallet::create([
            'hide_value' => $data['hideValue'],
            'name' => $data['name'],
            'status' => $data['status'],
            'amount' => $data['amount'],
        ])->toArray();
    }
}
