<?php

namespace App\Services;

use App\Repositories\ConfigurationRepository;

class ConfigurationService extends BasicService
{
    public function __construct(
        private readonly ConfigurationRepository $repository
    ) {
    }

    protected function getRepository(): ConfigurationRepository
    {
        return $this->repository;
    }

    public function findConfigValue(string $configName): mixed
    {
        $config = $this->findConfigByName($configName);
        return $config->getValue();
    }

    public function findConfigByName(string $configName): mixed
    {
        $config = $this->getRepository()->findByName($configName);
        return reset($config);
    }
}
