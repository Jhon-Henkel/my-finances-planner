<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $status
 * @property string $verify_hash
 * @property int $wrong_login_attempts
 * @property string $email_verified_at
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
}
