<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Models\Wallet\Wallet;

class WalletGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        return Wallet::findOrFail($id)->toArray();
    }
}
