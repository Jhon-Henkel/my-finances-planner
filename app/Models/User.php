<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Tenantable;

    protected $fillable = [
        'name',
        'email',
        'tenant_id',
        'unique_id',
        'password',
        'status',
        'account_group',
        'salary',
        'password',
        'wrong_login_attempts',
        'market_planner_value'
    ];
    protected $hidden = [
        'remember_token',
    ];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'email_verified_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
}
