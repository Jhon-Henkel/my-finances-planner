<?php

namespace App\Repositories;

use App\Models\ConfigModel;

class ConfigRepository extends BasicRepository
{
    protected ConfigModel $model;

    public function __construct(ConfigModel $model)
    {
        $this->model = $model;
    }
}
