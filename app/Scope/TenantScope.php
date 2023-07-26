<?php

namespace App\Scope;

use App\Enums\ConfigEnum;
use App\Tools\Auth\JwtTools;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $token = $_SERVER[ConfigEnum::X_MFP_USER_TOKEN] ?? '';
        $user = JwtTools::validateJWT($token);
        if (! $user) {
            return;
        }
        $builder->where($model->getTable() . '.tenant_id', $user->data->tenant_id);
    }
}