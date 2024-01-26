<?php

namespace App\Models\Log;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Model;

class AccessLogModel extends Model
{
    protected $table = 'access_log';
    protected $fillable = ['id', 'user_id', 'user_ip', 'user_agent', 'logged', 'comments', 'account_group', 'tenant_id'];
    protected $casts = ['created_at' => DateFormatEnum::ModelDefaultDateFormat->value];
    protected $hidden = [];
    public $timestamps = false;
}