<?php

namespace App\Models\Investment;

use App\Enums\DateEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use Tenantable, HasFactory;

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