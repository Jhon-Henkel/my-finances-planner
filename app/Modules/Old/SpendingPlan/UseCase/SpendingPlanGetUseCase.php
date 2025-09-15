<?php

namespace App\Modules\Old\SpendingPlan\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\Old\SpendingPlan\Domain\SpendingPlanModel;

class SpendingPlanGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        $item = SpendingPlanModel::query()->findOrFail($id);
        return [
            'id' => $item->id,
            'walletName' => $item->wallet()->name,
            'walletId' => $item->wallet_id,
            'amount' => floatval($item->amount),
            'description' => $item->description,
            'installments' => $item->installments,
            'forecast' => $item->forecast,
            'bankSlipCode' => $item->bank_slip_code,
            'observations' => $item->observations,
            'variable_spending' => $item->variable_spending,
            'createdAt' => $item->created_at,
            'updatedAt' => $item->updated_at,
        ];
    }
}
