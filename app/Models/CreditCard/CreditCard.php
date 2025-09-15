<?php

namespace App\Models\CreditCard;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property float $limit
 * @property string $due_date
 * @property string $closing_day
 * @property bool $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @mixin Builder
 */
class CreditCard extends Model
{
    use HasFactory;

    protected $table = 'credit_card';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'limit',
        'due_date',
        'closing_day',
        'status'
    ];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'status' => 'boolean'
    ];
}
