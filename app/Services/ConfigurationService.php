<?php

namespace App\Services;

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
        $config = $this->repository->findByName($configName);
        $config = reset($config);
        return $config->getValue();
    }
}