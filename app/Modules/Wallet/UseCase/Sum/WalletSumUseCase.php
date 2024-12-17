<?php

namespace App\Modules\Wallet\UseCase\Sum;

use App\Models\WalletModel;

class WalletSumUseCase
{
    public function execute(bool $sumHideValue = false): string
    {
        return WalletModel::query()
            ->where('hide_value', '=', (int)$sumHideValue)
            ->sum('amount');
    }
}
