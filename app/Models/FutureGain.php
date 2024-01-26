<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FutureGain extends Model
{
    use Tenantable, HasFactory;

    protected $table = 'future_gain';
    protected $fillable = ['id', 'wallet_id', 'description', 'amount', 'forecast', 'installments'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}