<?php

namespace App\Modules\Old\Wallet\UseCase\Sum;

use App\Models\Wallet\Wallet;

class WalletSumUseCase
{
    public function execute(bool $sumHideValue = false): string
    {
        return Wallet::query()
            ->where('hide_value', '=', (int)$sumHideValue)
            ->sum('amount');
    }
}
