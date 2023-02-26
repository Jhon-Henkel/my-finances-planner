<?php

namespace App\Services;

use App\Enums\ConfigEnum;
use App\Repositories\ConfigRepository;

class ConfigService extends BasicService
{
    protected ConfigRepository $repository;

    public function __construct(ConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): ConfigRepository
    {
        return $this->repository;
    }

    public function getConfigValue(string $configName): mixed
    {
        return $this->repository->findByName($configName)->first()->getAttribute(ConfigEnum::VALUE);
    }
}
