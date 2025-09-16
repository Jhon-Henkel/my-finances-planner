<?php

namespace App\Models\EarningPlan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property float $amount
 * @property bool $is_fixed
 * @property int $installments_quantity
 * @property int $recurrence
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Collection<int, EarningPlanInstallment> $installments
 *
 * @mixin Builder<EarningPlan>
 */
class EarningPlan extends Model
{
    protected $table = 'earning_plan';

    protected $fillable = [
        'name',
        'amount',
        'is_fixed',
        'installments_quantity',
        'recurrence',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'recurrence' => 'integer',
        'is_fixed' => 'boolean',
    ];

    public function installments(): HasMany
    {
        return $this->hasMany(EarningPlanInstallment::class)->orderBy('number');
    }
}
