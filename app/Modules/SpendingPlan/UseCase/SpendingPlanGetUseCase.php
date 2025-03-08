<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Infra\Shared\UseCase\Get\IGetUseCase;
use App\Modules\SpendingPlan\Domain\SpendingPlanModel;

class SpendingPlanGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        $item = SpendingPlanModel::query()->findOrFail($id);
        return [
            'id' => $item->id,
            'walletName' => $item->wallet()->name,
            'walletId' => $item->wallet_id,
            'amount' => $item['amount'],
            'description' => $item->description,
            'installments' => $item->installments,
            'forecast' => $item->forecast,
            'bankSlipCode' => $item->bank_slip_code,
            'createdAt' => $item->created_at,
            'updatedAt' => $item->updated_at,
        ];
    }
}
