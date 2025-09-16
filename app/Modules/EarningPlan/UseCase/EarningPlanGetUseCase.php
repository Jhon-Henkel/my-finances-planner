<?php

namespace App\Modules\EarningPlan\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Models\EarningPlan\EarningPlan;

class EarningPlanGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        return EarningPlan::with('installments')->findOrFail($id)->toArray();
    }
}
