<?php

namespace App\Models\Trait;

use App\Scope\TenantScope;
use App\Models\Tenant;
use App\Tools\Auth\JwtTools;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Tenantable
{
    protected static function bootTenantable(): void
    {
        static::addGlobalScope(new TenantScope);
        $token = $_SERVER['HTTP_X_MFP_USER_TOKEN'] ?? '';
        $user = JwtTools::validateJWT($token);
        if (! $user) {
            return;
        }
        static::creating(function ($model) use ($user) {
            $model->tenant_id = $user->data->tenant_id;
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}