<?php

namespace App\Models;

use App\Enums\DateEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Model;

class WalletModel extends Model
{
    use Tenantable;

    protected $table = 'wallets';
    protected $fillable = ['id', 'name', 'type', 'amount'];
    protected $casts = [
        'created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,
        'updated_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT
    ];
    protected $hidden = [];
    public $timestamps = false;
}