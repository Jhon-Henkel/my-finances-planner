<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCardTransaction extends Model
{
    use HasFactory;

    protected $table = 'credit_card_transaction';
    protected $fillable = ['id', 'credit_card_id', 'name', 'value', 'installments', 'next_installment'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
