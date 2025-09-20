<?php

namespace App\Modules\Configurations\UseCase;

use App\Services\ConfigurationService;

class ConfigurationsUpdateUseCase
{
    public function __construct(private readonly ConfigurationService $service)
    {
    }

    public function execute(array $data): void
    {
        $this->service->updateConfigs($data);
    }
}
