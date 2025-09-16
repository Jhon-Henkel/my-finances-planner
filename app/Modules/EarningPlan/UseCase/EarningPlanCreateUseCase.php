<?php

namespace App\Modules\EarningPlan\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;
use Carbon\Carbon;

class EarningPlanCreateUseCase implements ICreateUseCaseV2
{
    public function execute(array $data): array
    {
        $isFixed = $data['isFixed'];
        $recurrence = $data['recurrence'];

        $plan = EarningPlan::create([
            'name' => $data['name'],
            'amount' => $data['amount'],
            'is_fixed' => $isFixed,
            'installments_quantity' => $isFixed ? 0 : $data['installments'],
            'recurrence' => $recurrence,
        ]);

        if (!$isFixed) {
            $firstDueDate = Carbon::parse($data['dueDate']);

            for ($i = 1; $i <= $data['installments']; $i++) {
                EarningPlanInstallment::create([
                    'earning_plan_id' => $plan->id,
                    'number' => $i,
                    'amount' => $data['amount'],
                    'due_date' => (clone $firstDueDate)->addMonthsNoOverflow(($i - 1) * $recurrence),
                    'is_received' => false,
                ]);
            }
        }

        return [];
    }
}
