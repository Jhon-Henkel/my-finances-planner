<?php

namespace App\Scope;

use App\Tools\Request\RequestTools;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $user = RequestTools::getUserDataInRequest();
        if (! $user) {
            return;
        }
        $builder->where($model->getTable() . '.tenant_id', $user->data->tenant_id);
    }
}