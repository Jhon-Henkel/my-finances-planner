<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementModel extends Model
{
    use Tenantable, HasFactory;

    protected $table = 'movements';
    protected $fillable = ['id', 'wallet_id', 'description', 'type', 'amount'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}