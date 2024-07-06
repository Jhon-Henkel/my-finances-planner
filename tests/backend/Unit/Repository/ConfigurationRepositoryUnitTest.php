<?php

namespace Tests\backend\Unit\Repository;

use App\Models\Configurations;
use App\Repositories\ConfigurationRepository;
use App\Resources\ConfigurationResource;
use Mockery;
use Tests\backend\Falcon9;

class ConfigurationRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = Mockery::mock(Configurations::class);
        $mocks = [$mockModel, new ConfigurationResource()];

        $mockRepository = Mockery::mock(ConfigurationRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(Configurations::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = Mockery::mock(Configurations::class);
        $mocks = [$mockModel, new ConfigurationResource()];

        $mockRepository = Mockery::mock(ConfigurationRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(ConfigurationResource::class, $result);
    }
}
