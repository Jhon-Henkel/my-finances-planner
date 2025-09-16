<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Models\SpendingPlan\SpendingPlan;

class SpendingPlanGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        return SpendingPlan::with('installments')->findOrFail($id)->toArray();
    }
}
