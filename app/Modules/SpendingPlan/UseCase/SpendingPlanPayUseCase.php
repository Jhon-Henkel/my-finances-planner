<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\UseCase\MovementCreateUseCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SpendingPlanPayUseCase implements ICreateUseCaseV2
{
    public function __construct(private MovementCreateUseCase $movementCreateUseCase)
    {
    }

    public function execute(array $data): array
    {
        $planId = $data['planId'] ?? 0;
        $walletId = $data['walletId'] ?? 0;

        if ($planId <= 0 || $walletId <= 0) {
            throw new ModelNotFoundException('Invalid planId or walletId');
        }

        $plan = SpendingPlan::findOrFail($planId);

        $amount = $plan->amount;
        $description = 'Pagamento: ' . $plan->name;

        if (!$plan->is_fixed) {
            $number = $data['installmentNumber'] ?? 0;

            if ($number <= 0) {
                throw new ModelNotFoundException('installmentNumber is required for non-fixed spending plans');
            }

            $inst = SpendingPlanInstallment::where('spending_plan_id', $plan->id)->where('number', $number)->firstOrFail();

            $inst->is_paid = true;
            $inst->save();

            $amount = $inst->amount;
            $description .= " #$number";
        }

        $this->movementCreateUseCase->execute([
            'walletId' => $walletId,
            'description' => $description,
            'type' => MovementTypeEnum::Spent->value,
            'amount' => (float)$amount,
        ]);

        return [];
    }
}
