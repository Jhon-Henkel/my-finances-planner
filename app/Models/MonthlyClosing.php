<?php

namespace App\Models;

use App\Enums\DateEnum;
use Illuminate\Database\Eloquent\Model;

class MonthlyClosing extends Model
{
    protected $table = 'monthly_closing';
    protected $fillable = ['id', 'predicted_earnings', 'predicted_expenses', 'real_earnings', 'real_expenses', 'balance'];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
    protected $hidden = [];
    public $timestamps = false;
}