<?php

namespace App\Models\Investment;

use App\Enums\DateFormatEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use Tenantable;
    use HasFactory;

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
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
