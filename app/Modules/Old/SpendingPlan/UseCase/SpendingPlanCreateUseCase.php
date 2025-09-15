<?php

namespace App\Modules\Old\SpendingPlan\UseCase;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\Old\SpendingPlan\Domain\SpendingPlanModel;

class SpendingPlanCreateUseCase implements ICreateUseCase
{
    public function execute(array $data): bool
    {
        return SpendingPlanModel::query()->insert([
            'wallet_id' => $data['walletId'],
            'description' => $data['description'],
            'forecast' => $data['forecast'],
            'amount' => $data['amount'],
            'installments' => $data['installments'],
            'bank_slip_code' => $data['bankSlipCode'] ?? null,
            'observations' => $data['observations'] ?? null,
            'variable_spending' => $data['variableSpending'],
        ]);
    }
}
