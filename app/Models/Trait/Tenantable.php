<?php

namespace App\Models\Trait;

use App\Models\Tenant;
use App\Scope\TenantScope;
use App\Tools\Request\RequestTools;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Tenantable
{
    protected static function bootTenantable(): void
    {
        static::addGlobalScope(new TenantScope);
        $user = RequestTools::getUserDataInRequest();
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