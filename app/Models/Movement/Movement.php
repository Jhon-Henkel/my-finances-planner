<?php

namespace App\Models\Movement;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $wallet_id
 * @property string $description
 * @property int $type
 * @property float $amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @mixin Builder<Movement>
 */
class Movement extends Model
{
    use HasFactory;

    protected $table = 'movements';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'wallet_id',
        'description',
        'type',
        'amount'
    ];

    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
}
