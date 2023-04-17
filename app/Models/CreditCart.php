<?php

namespace App\Models;

use App\Enums\DateEnum;
use Illuminate\Database\Eloquent\Model;

class CreditCart extends Model
{
    protected $table = 'credit_card';
    protected $fillable = ['id', 'name', 'limit', 'due_date', 'closing_day'];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
    protected $hidden = [];
    public $timestamps = false;
}