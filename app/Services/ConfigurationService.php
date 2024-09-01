<?php

namespace App\Services;

use App\DTO\ConfigurationDTO;
use App\Models\User;
use App\Repositories\ConfigurationRepository;
use App\Services\Database\DatabaseConnectionService;

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

    public function findConfigByName(string $configName, User $userToConnect = null): null|ConfigurationDTO
    {
        if (! is_null($userToConnect)) {
            $connection = new DatabaseConnectionService();
            $connection->connectUser($userToConnect);
        }
        $config = $this->getRepository()->findByName($configName);
        return reset($config);
    }
}
