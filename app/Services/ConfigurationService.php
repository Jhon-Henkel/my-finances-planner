<?php

namespace App\Services;

use App\DTO\ConfigurationDTO;
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

    public function findConfigByName(string $configName): ConfigurationDTO
    {
        $config = $this->getRepository()->findByName($configName);
        return reset($config);
    }
}
