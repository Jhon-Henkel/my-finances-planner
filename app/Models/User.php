<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
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
 * @property string $unique_id
 * @property string $password
 * @property int $status
 * @property string $verify_hash
 * @property int $wrong_login_attempts
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
        'unique_id',
        'password',
        'status',
        'tenant_id',
        'verify_hash',
        'wrong_login_attempts',
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
}
