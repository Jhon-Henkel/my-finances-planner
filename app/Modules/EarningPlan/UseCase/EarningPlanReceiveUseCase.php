<?php

namespace App\Modules\EarningPlan\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\UseCase\MovementCreateUseCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EarningPlanReceiveUseCase implements ICreateUseCaseV2
{
    public function __construct(private MovementCreateUseCase $movementCreateUseCase)
    {
    }

    public function execute(array $data): array
    {
        $planId = (int)($data['planId'] ?? 0);
        $walletId = (int)($data['walletId'] ?? 0);
        if ($planId <= 0 || $walletId <= 0) {
            throw new ModelNotFoundException('Invalid planId or walletId');
        }

        /** @var EarningPlan $plan */
        $plan = EarningPlan::findOrFail($planId);

        $amount = $plan->amount;
        $description = 'Recebimento: ' . $plan->name;

        if (!$plan->is_fixed) {
            $number = $data['installmentNumber'] ?? 0;

            if ($number <= 0) {
                throw new ModelNotFoundException('installmentNumber is required for non-fixed earning plans');
            }

            $inst = EarningPlanInstallment::where('earning_plan_id', $plan->id)->where('number', $number)->firstOrFail();

            $inst->is_received = true;
            $inst->save();

            $amount = $inst->amount;
            $description .= " #$number";
        }

        $this->movementCreateUseCase->execute([
            'walletId' => $walletId,
            'description' => $description,
            'type' => MovementTypeEnum::Gain->value,
            'amount' => $amount,
        ]);

        return [];
    }
}
