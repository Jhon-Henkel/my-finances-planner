<?php

namespace App\Services;

use App\Enums\ConfigEnum;
use App\Repositories\ConfigurationRepository;

class ConfigurationService extends BasicService
{
    protected ConfigurationRepository $repository;

    public function __construct(ConfigurationRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): ConfigurationRepository
    {
        return $this->repository;
    }

    public function findConfigValue(string $configName): mixed
    {
        return $this->repository->findByName($configName)->getValue();
    }
}