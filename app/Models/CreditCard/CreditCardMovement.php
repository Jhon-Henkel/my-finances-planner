<?php

namespace App\Models\CreditCard;

use App\Enums\DateEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCardMovement extends Model
{
    use Tenantable, HasFactory;

    protected $table = 'credit_card_movement';
    protected $fillable = ['id', 'credit_card_id', 'description', 'type', 'amount'];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
    protected $hidden = [];
    public $timestamps = false;
}