<?php

namespace App\Modules\Wallet\Model;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @mixin Builder
 */
class WalletModel extends Model
{
    use HasFactory;

    protected $table = 'wallets';
    protected $fillable = ['id', 'name', 'type', 'amount', 'hide_value', 'status'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
