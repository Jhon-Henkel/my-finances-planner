<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Infra\Shared\UseCase\Insert\IInsertUseCase;
use App\Modules\SpendingPlan\Domain\SpendingPlanModel;

class SpendingPlanInsertUseCase implements IInsertUseCase
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
