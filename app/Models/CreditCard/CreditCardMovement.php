<?php

namespace App\Models\CreditCard;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class CreditCardMovement extends Model
{
    protected $table = 'credit_card_movement';
    protected $fillable = ['id', 'credit_card_id', 'description', 'type', 'amount'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
