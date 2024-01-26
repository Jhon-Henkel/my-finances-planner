<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCardTransaction extends Model
{
    use Tenantable, HasFactory;

    protected $table = 'credit_card_transaction';
    protected $fillable = ['id', 'credit_card_id', 'name', 'value', 'installments', 'next_installment'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}