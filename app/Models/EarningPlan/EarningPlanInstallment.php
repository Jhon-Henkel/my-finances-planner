<?php

namespace App\Models\EarningPlan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $earning_plan_id
 * @property int $number
 * @property float $amount
 * @property string $due_date
 * @property bool $is_received
 *
 * @mixin Builder<EarningPlanInstallment>
 */
class EarningPlanInstallment extends Model
{
    protected $table = 'earning_plan_installments';

    protected $fillable = [
        'earning_plan_id',
        'number',
        'amount',
        'due_date',
        'is_received',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'is_received' => 'boolean',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(EarningPlan::class, 'earning_plan_id');
    }
}
