<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;

class SpendingPlanDeleteUseCase implements IDeleteUseCase
{
    public function execute(int $id): void
    {
        SpendingPlanInstallment::where('spending_plan_id', $id)
            ->where('is_paid', false)
            ->delete();

        SpendingPlan::find($id)->delete();
    }
}
