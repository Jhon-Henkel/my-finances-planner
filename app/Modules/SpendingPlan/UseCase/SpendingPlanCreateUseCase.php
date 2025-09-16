<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use Carbon\Carbon;

class SpendingPlanCreateUseCase implements ICreateUseCaseV2
{
    public function execute(array $data): array
    {
        $isFixed = $data['isFixed'];
        $recurrence = $data['recurrence'];

        $plan = SpendingPlan::create([
            'name' => $data['name'],
            'amount' => $data['amount'],
            'is_fixed' => $isFixed,
            'installments_quantity' => $isFixed ? 0 : $data['installments'],
            'recurrence' => $recurrence,
        ]);

        if (!$isFixed) {
            $firstDueDate = Carbon::parse($data['dueDate']);

            for ($i = 1; $i <= $data['installments']; $i++) {
                SpendingPlanInstallment::create([
                    'spending_plan_id' => $plan->id,
                    'number' => $i,
                    'amount' => $data['amount'],
                    'due_date' => (clone $firstDueDate)->addMonthsNoOverflow(($i - 1) * $recurrence),
                    'bank_slip_code' => $data['bankSlipCode'] ?? null,
                    'is_paid' => false,
                ]);
            }
        }

        return [];
    }
}
