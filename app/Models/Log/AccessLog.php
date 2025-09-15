<?php

namespace App\Models\Log;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $user_ip
 * @property string $user_agent
 * @property bool $logged
 * @property string $comments
 * @property string $created_at
 *
 * @mixin Builder<AccessLog>
 */
class AccessLog extends Model
{
    protected $table = 'access_log';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'user_ip',
        'user_agent',
        'logged',
        'comments'
    ];

    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'logged' => 'boolean'
    ];
}
