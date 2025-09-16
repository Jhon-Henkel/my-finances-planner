<?php

namespace App\Models\SpendingPlan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $spending_plan_id
 * @property int $number
 * @property float $amount
 * @property string $due_date
 * @property bool $is_paid
 * @property string $bank_slip_code
 *
 * @mixin Builder<SpendingPlanInstallment>
 */
class SpendingPlanInstallment extends Model
{
    protected $table = 'spending_plan_installments';

    protected $fillable = [
        'spending_plan_id',
        'number',
        'amount',
        'due_date',
        'is_paid',
        'bank_slip_code',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'is_paid' => 'boolean',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SpendingPlan::class, 'spending_plan_id');
    }
}
