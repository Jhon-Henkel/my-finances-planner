<?php

namespace App\Modules\Old\MarketControl\UseCase\GetWalletList;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Models\Wallet\Wallet;

readonly class GetWalletListUseCase
{
    public function execute(): array
    {
        $wallets = Wallet::where('status', StatusActiveInactiveEnum::Active->value)->get();
        return $wallets->toArray();
    }
}
