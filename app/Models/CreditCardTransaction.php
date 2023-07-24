<?php

namespace App\Models;

use App\Enums\DateEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Model;

class CreditCardTransaction extends Model
{
    use Tenantable;

    protected $table = 'credit_card_transaction';
    protected $fillable = ['id', 'credit_card_id', 'name', 'value', 'installments', 'next_installment'];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
    protected $hidden = [];
    public $timestamps = false;
}