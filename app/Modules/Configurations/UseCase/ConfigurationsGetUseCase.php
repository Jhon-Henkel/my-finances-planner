<?php

namespace App\Modules\Configurations\UseCase;

use App\Repositories\ConfigurationRepository;

class ConfigurationsGetUseCase
{
    public function __construct(private readonly ConfigurationRepository $repository)
    {
    }

    public function execute(): array
    {
        return $this->repository->findAll();
    }
}
