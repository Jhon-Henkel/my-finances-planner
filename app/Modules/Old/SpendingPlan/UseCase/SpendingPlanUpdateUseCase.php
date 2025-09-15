<?php

namespace App\Modules\Old\SpendingPlan\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Modules\Old\SpendingPlan\Domain\SpendingPlanModel;

class SpendingPlanUpdateUseCase implements IUpdateUseCase
{
    public function execute(array $data, int $id): bool
    {
        $item = SpendingPlanModel::query()->findOrFail($id);
        return $item->update([
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
