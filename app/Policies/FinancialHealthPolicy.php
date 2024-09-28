<?php

namespace App\Policies;

use App\Models\User;

class FinancialHealthPolicy
{
    public function list(User $user): bool
    {
        return $user->isFreePlan() == false;
    }
}
