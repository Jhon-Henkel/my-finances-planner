<?php

namespace App\Services;

use App\Enums\ConfigEnum;
use App\Enums\DateEnum;
use App\Repositories\ConfigurationRepository;
use App\Tools\RequestTools;
use Illuminate\Support\Facades\Cache;

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
        $config = $this->findConfigByName($configName);
        return $config->getValue();
    }

    public function findConfigByName(string $configName): mixed
    {
        $config = $this->getRepository()->findByName($configName);
        return reset($config);
    }

    public function getMfpToken()
    {
        $token = Cache::get(ConfigEnum::MFP_TOKEN);
        if (! $token) {
            $token = env('PUSHER_APP_KEY');
            Cache::put(ConfigEnum::MFP_TOKEN, $token, DateEnum::TWO_HOUR_IN_SECONDS);
        }
        return $token;
    }
}