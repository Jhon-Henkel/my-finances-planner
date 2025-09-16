<?php

namespace App\Modules\EarningPlan\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;

class EarningPlanDeleteUseCase implements IDeleteUseCase
{
    public function execute(int $id): void
    {
        EarningPlanInstallment::where('earning_plan_id', $id)
            ->where('is_received', false)
            ->delete();

        EarningPlan::find($id)->delete();
    }
}
