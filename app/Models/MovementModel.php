<?php

namespace App\Models;

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
 *
 * @mixin Builder
 */
class MovementModel extends Model
{
    use HasFactory;

    protected $table = 'movements';
    protected $fillable = ['id', 'wallet_id', 'description', 'type', 'amount'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
    protected $hidden = [];
    public $timestamps = false;
}
