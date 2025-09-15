<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\Wallet\Wallet;

class WalletCreateUseCase implements ICreateUseCaseV2
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
