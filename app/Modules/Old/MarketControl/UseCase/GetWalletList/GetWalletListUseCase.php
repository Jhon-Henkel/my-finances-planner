<?php

namespace App\Modules\Old\MarketControl\UseCase\GetWalletList;

use App\Enums\StatusEnum;
use App\Models\WalletModel;

readonly class GetWalletListUseCase
{
    public function execute(): array
    {
        $wallets = WalletModel::where('status', StatusEnum::Active->value)->get();
        return $wallets->toArray();
    }
}
