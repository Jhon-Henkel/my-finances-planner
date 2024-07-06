<?php

namespace App\Models;

use App\Enums\DateFormatEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Configurations extends Model
{
    use Tenantable;

    protected $table = 'configurations';
    protected $fillable = ['id', 'name', 'value'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
