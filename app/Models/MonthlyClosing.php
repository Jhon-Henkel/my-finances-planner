<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyClosing extends Model
{
    use HasFactory;

    protected $table = 'monthly_closing';
    protected $fillable = [
        'id',
        'predicted_earnings',
        'predicted_expenses',
        'real_earnings',
        'real_expenses',
        'balance',
        'tenant_id'
    ];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
