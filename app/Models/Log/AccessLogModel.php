<?php

namespace App\Models\Log;

use App\Enums\DateEnum;
use App\Models\Trait\Tenantable;
use Illuminate\Database\Eloquent\Model;

class AccessLogModel extends Model
{
    protected $table = 'access_log';
    protected $fillable = ['id', 'user_id', 'user_ip', 'user_agent', 'logged', 'comments', 'account_group', 'tenant_id'];
    protected $casts = ['created_at' => DateEnum::MODEL_DEFAULT_DATE_FORMAT,];
    protected $hidden = [];
    public $timestamps = false;
}