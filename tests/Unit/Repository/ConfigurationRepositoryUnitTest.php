<?php

namespace Tests\Unit\Repository;

use App\Models\Configurations;
use App\Repositories\ConfigurationRepository;
use App\Resources\ConfigurationResource;
use Tests\TestCase;

class ConfigurationRepositoryUnitTest extends TestCase
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(Configurations::class);
        $mockRepository = \Mockery::mock(ConfigurationRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(Configurations::class, $mockRepository->getModel()
        );
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(Configurations::class);
        $mockRepository = \Mockery::mock(ConfigurationRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(ConfigurationResource::class, $result);
    }
}