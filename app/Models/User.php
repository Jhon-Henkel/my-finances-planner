<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use App\Enums\Plan\PlanNameEnum;
use App\Models\User\Plan;
use App\Models\User\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property null|string $subscription_id
 * @property string $password
 * @property int $status
 * @property string $verify_hash
 * @property int $wrong_login_attempts
 * @property string $email_verified_at
 * @property int $plan_id
 *
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'tenant_id',
        'plan_id',
        'verify_hash',
        'wrong_login_attempts',
        'email_verified_at'
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'email_verified_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];

    public function tenant(): Tenant
    {
        return $this->belongsTo(Tenant::class)->first();
    }

    public function plan(): Plan
    {
        return $this->belongsTo(Plan::class)->first();
    }

    public function mustValidatePlanLimit(): bool
    {
        return $this->plan()->name === PlanNameEnum::Free->value;
    }
}
