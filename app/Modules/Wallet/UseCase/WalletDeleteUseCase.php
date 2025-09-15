<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\Wallet\Wallet;

class WalletDeleteUseCase implements IDeleteUseCase
{
    public function execute(int $id): void
    {
        Wallet::find($id)->delete();
    }
}
