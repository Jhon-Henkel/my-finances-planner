<?php

namespace App\Models\Log;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class AccessLogModel extends Model
{
    protected $table = 'access_log';
    protected $fillable = ['id', 'user_id', 'user_ip', 'user_agent', 'logged', 'comments'];
    protected $casts = ['created_at' => DateFormatEnum::ModelDefaultDateFormat->value];
    protected $hidden = [];
    public $timestamps = false;
}
