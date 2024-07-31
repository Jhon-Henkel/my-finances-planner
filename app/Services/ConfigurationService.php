<?php

namespace App\Services;

use App\DTO\ConfigurationDTO;
use App\Repositories\ConfigurationRepository;

class ConfigurationService extends BasicService
{
    public function __construct(private readonly ConfigurationRepository $repository)
    {
    }

    protected function getRepository(): ConfigurationRepository
    {
        return $this->repository;
    }

    public function updateConfigs(array $data): void
    {
        foreach ($data as $config) {
            $configDB = $this->findConfigByName($config['name']);
            if (!$configDB) {
                continue;
            }
            $configDB->setValue($config['value']);
            $this->getRepository()->update($configDB->getId(), $configDB);
        }
    }

    public function findConfigByName(string $configName): null|ConfigurationDTO
    {
        $config = $this->getRepository()->findByName($configName);
        return reset($config);
    }
}
