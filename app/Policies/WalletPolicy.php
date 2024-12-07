<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Wallet\Model\WalletModel;

class WalletPolicy
{
    public function create(User $user): bool
    {
        if ($user->isFreePlan()) {
            $totalWallets = WalletModel::count();
            return $totalWallets < $user->plan()->wallet_limit;
        }
        return true;
    }
}
