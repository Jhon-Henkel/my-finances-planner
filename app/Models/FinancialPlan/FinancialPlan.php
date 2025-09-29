<?php

namespace App\Models\FinancialPlan;

use App\Modules\FinancialPlan\Enum\FinancialPlanInstallmentEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $installments
 * @property bool $variable
 * @property bool $done
 * @property int $recurrence
 * @property string $observation
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Collection<FinancialPlanInstallment> $installments_data
 *
 * @mixin Builder<FinancialPlan>
 */
class FinancialPlan extends Model
{
    protected $table = 'financial_plan';

    protected $fillable = [
        'name',
        'type',
        'installments',
        'variable',
        'done',
        'recurrence',
        'observation',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'done' => 'boolean',
        'variable' => 'boolean',
    ];

    /**
     * @return HasMany<FinancialPlanInstallment, $this>
     */
    public function installments_data(): HasMany
    {
        return $this->hasMany(FinancialPlanInstallment::class, 'financial_plan_id', 'id');
    }

    public function isFixInstallment(): bool
    {
        return $this->installments === FinancialPlanInstallmentEnum::Fix->value;
    }
}
