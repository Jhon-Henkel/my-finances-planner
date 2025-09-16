<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class SpendingPlanUpdateUseCase implements IUpdateUseCaseV2
{
    public function execute(array $data, int $id): array
    {
        $plan = SpendingPlan::findOrFail($id);

        if (array_key_exists('isFixed', $data)) {
            $newIsFixed = $data['isFixed'];
            if ($newIsFixed && !$plan->is_fixed) {
                $plan->installments()->delete();
                $plan->installments_quantity = 0;
                $plan->is_fixed = true;
                $plan->save();
            } elseif (!$newIsFixed && $plan->is_fixed) {
                $plan->is_fixed = false;
                $plan->save();
            }
        }

        $updateFields = [];
        foreach ([
            'name' => 'name',
            'amount' => 'amount',
            'installments' => 'installments',
            'recurrence' => 'recurrence',
            'isFixed' => 'is_fixed',
        ] as $inputKey => $field) {
            if (array_key_exists($inputKey, $data)) {
                $updateFields[$field] = $data[$inputKey];
            }
        }

        if (!empty($updateFields)) {
            $plan->update($updateFields);
        }

        if ($plan->is_fixed) {
            return [];
        }

        if (array_key_exists('installments', $data)) {
            $this->adjustInstallments($plan, $data['installments'], $data);
        }

        if (isset($data['installmentUpdate']) && is_array($data['installmentUpdate'])) {
            $this->applyInstallmentUpdate($plan, $data['installmentUpdate']);
        }

        return [];
    }

    private function adjustInstallments(SpendingPlan $plan, int $newCount, array $data): void
    {
        $currentCount = $plan->installments()->count();
        if ($newCount === $currentCount) {
            return;
        }

        $rec = array_key_exists('recurrence', $data) ? $data['recurrence'] : ($plan->recurrence ?: 1);
        $step = $rec ?: 1;

        if ($newCount > $currentCount) {
            $existing = $plan->installments;
            $last = $existing->last();
            $startNumber = $currentCount + 1;
            $perInstallmentAmount = $data['amount'] ?? $plan->amount;
            $baseDueDate = $last ? Carbon::parse($last->due_date) : (isset($data['dueDate']) ? Carbon::parse($data['dueDate']) : Carbon::now());
            for ($i = $startNumber; $i <= $newCount; $i++) {
                SpendingPlanInstallment::create([
                    'spending_plan_id' => $plan->id,
                    'number' => $i,
                    'amount' => $perInstallmentAmount,
                    'due_date' => (clone $baseDueDate)->addMonthsNoOverflow(($i - $startNumber + 1) * $step),
                    'bank_slip_code' => $data['bankSlipCode'] ?? null,
                    'is_paid' => false,
                ]);
            }
        } else {
            $plan->installments()->where('number', '>', $newCount)->delete();
        }
    }

    private function applyInstallmentUpdate(SpendingPlan $plan, array $update): void
    {
        if ($plan->is_fixed) {
            return;
        }
        $number = (int)$update['installmentNumber'];
        $applyToNext = (bool)$update['applyToNext'];

        $query = $plan->installments()->where('number', '>=', $number);
        if (!$applyToNext) {
            $query = $plan->installments()->where('number', '=', $number);
        }

        $changes = [];
        if (array_key_exists('amount', $update)) {
            $changes['amount'] = $update['amount'];
        }
        if (array_key_exists('dueDate', $update)) {
            $changes['due_date'] = Carbon::parse($update['dueDate'])->toDateString();
        }
        if (array_key_exists('bankSlipCode', $update)) {
            $changes['bank_slip_code'] = $update['bankSlipCode'];
        }
        if (array_key_exists('isPaid', $update)) {
            $changes['is_paid'] = (bool)$update['isPaid'];
        }

        if (!empty($changes)) {
            $query->update($changes);
        }
    }
}
