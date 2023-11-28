<?php

namespace App\Models\Investment;

use App\Enums\DateEnum;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $table = 'investment';
    protected $fillable = [
        'id', 
        'credit_card_id',
        'description',
        'type',
        'amount',
        'liquidity',
        'profitability',
        'tenant_id'
    ];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
    protected $hidden = [];
    public $timestamps = false;
}