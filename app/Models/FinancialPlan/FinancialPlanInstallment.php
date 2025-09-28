<?php

namespace App\Models\FinancialPlan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $financial_plan_id
 * @property int $installment
 * @property float $amount
 * @property bool $done
 * @property string $maturity
 * @property string $payment_info
 * @property string $created_at
 * @property string $updated_at
 *
 * @mixin Builder<FinancialPlanInstallment>
 */
class FinancialPlanInstallment extends Model
{
    protected $table = 'financial_plan_installment';

    protected $fillable = [
        'financial_plan_id',
        'installment',
        'amount',
        'done',
        'payment_info',
        'maturity',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'maturity' => 'datetime:Y-m-d H:i:s',
        'done' => 'boolean'
    ];
}
