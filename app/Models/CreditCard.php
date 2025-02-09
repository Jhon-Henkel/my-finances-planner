<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 *
 * @mixin Builder
 */
class CreditCard extends Model
{
    use HasFactory;

    protected $table = 'credit_card';
    protected $fillable = ['id', 'name', 'limit', 'due_date', 'closing_day', 'status'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
