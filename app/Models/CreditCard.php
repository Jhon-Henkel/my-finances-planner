<?php

namespace App\Models;

use App\Enums\DateEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use Tenantable, HasFactory;

    protected $table = 'credit_card';
    protected $fillable = ['id', 'name', 'limit', 'due_date', 'closing_day'];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
    protected $hidden = [];
    public $timestamps = false;
}