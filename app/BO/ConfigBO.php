<?php

namespace App\BO;

use App\Enums\ConfigEnum;
use App\Repositories\ConfigRepository;

class ConfigBO extends BasicBO
{
    protected $repository;

    public function __construct(ConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getConfigValue(string $configName): mixed
    {
        return $this->repository->findByName($configName)->first()->getAttribute(ConfigEnum::VALUE);
    }
}
