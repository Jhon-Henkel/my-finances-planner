<?php

namespace App\Services;

use App\Enums\ConfigEnum;
use App\Enums\TimeNumberEnum;
use App\Repositories\ConfigurationRepository;
use Illuminate\Support\Facades\Cache;

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

    public function getMfpToken()
    {
        $token = Cache::get(ConfigEnum::MfpTokenKey->value);
        if (! $token) {
            $token = env('PUSHER_APP_KEY');
            Cache::put(ConfigEnum::MfpTokenKey->value, $token, TimeNumberEnum::TwoHourInSeconds->value);
        }
        return $token;
    }
}