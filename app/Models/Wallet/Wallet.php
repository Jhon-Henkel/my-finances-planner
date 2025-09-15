<?php

namespace App\Models\Wallet;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $amount
 * @property string $name
 * @property int $status
 * @property bool $hide_value
 * @property string $created_at
 * @property string $updated_at
 *
 * @mixin Builder<Wallet>
 */
class Wallet extends Model
{
    protected $table = 'wallets';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'amount',
        'hide_value',
        'status'
    ];

    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'hide_value' => 'boolean'
    ];
}
