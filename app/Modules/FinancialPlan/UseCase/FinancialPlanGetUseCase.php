<?php

namespace App\Modules\FinancialPlan\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Models\FinancialPlan\FinancialPlan;
use App\Models\Wallet\Wallet;

class FinancialPlanGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        return FinancialPlan::with('installments_data')
            ->findOrFail($id)
            ->toArray();
    }
}
