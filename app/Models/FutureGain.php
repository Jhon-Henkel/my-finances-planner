<?php

namespace App\Models;

use App\Enums\DateEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FutureGain extends Model
{
    use Tenantable, HasFactory;

    protected $table = 'future_gain';
    protected $fillable = ['id', 'wallet_id', 'description', 'amount', 'forecast', 'installments'];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
    protected $hidden = [];
    public $timestamps = false;
}