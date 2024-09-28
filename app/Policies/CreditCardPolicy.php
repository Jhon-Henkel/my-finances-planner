<?php

namespace App\Policies;

use App\Models\CreditCard;
use App\Models\User;

class CreditCardPolicy
{
    public function create(User $user): bool
    {
        if ($user->isFreePlan()) {
            $totalWallets = CreditCard::count();
            return $totalWallets < $user->plan()->credit_card_limit;
        }
        return true;
    }
}
