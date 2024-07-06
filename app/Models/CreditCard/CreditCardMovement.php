<?php

namespace App\Models\CreditCard;

use App\Enums\DateFormatEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCardMovement extends Model
{
    use Tenantable;
    use HasFactory;

    protected $table = 'credit_card_movement';
    protected $fillable = ['id', 'credit_card_id', 'description', 'type', 'amount'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
