<?php

namespace App\Modules\FinancialPlan\UseCase;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\FinancialPlan\FinancialPlan;
use App\Models\FinancialPlan\FinancialPlanInstallment;
use App\Modules\FinancialPlan\Enum\FinancialPlanInstallmentEnum;
use Illuminate\Support\Carbon;

class FinancialPlanCreateUseCase implements ICreateUseCase
{
    public function execute(array $data): array
    {
        $item = FinancialPlan::create([
            'type' => $data['type'],
            'variable' => $data['variable'],
            'name' => $data['name'],
            'installments' => $data['installments'],
            'done' => false,
            'observation' => $data['observation'],
            'recurrence' => $data['recurrence'],
        ]);

        $this->insertInstallments($item, $data);

        return $item->toArray();
    }

    protected function insertInstallments(FinancialPlan $plan, array $data): void
    {
        for ($i = 0; $i < $data['installments']; $i++) {
            $maturity = $data['maturity'];
            $installment = $plan->isFixInstallment() ? FinancialPlanInstallmentEnum::Fix->value : $i + 1;

            if ($i > 0) {
                $maturity = Carbon::createFromTimeString($maturity)->addMonths($installment)->toDateTimeString();
            }

            FinancialPlanInstallment::create([
                'done' => false,
                'amount' => $data['amount'],
                'financial_plan_id' => $plan->id,
                'payment_info' => $data['paymentInfo'],
                'installment' => $installment,
                'maturity' => $maturity,
            ]);
        }
    }
}
