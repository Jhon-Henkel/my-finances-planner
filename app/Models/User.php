<?php

namespace App\Models;

use App\Enums\DateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'unique_id',
        'password',
        'status',
        'account_group',
        'salary',
        'password',
        'wrong_login_attempts'
    ];
    protected $hidden = [
        'remember_token',
    ];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'email_verified_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
}