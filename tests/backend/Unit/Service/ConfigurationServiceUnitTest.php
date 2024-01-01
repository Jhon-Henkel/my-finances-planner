<?php

namespace Tests\backend\Unit\Service;

use App\DTO\ConfigurationDTO;
use App\Repositories\ConfigurationRepository;
use App\Services\ConfigurationService;
use Mockery;
use Tests\backend\Falcon9;

class ConfigurationServiceUnitTest extends Falcon9
{
    public function testFindConfigValue()
    {
        $config = new ConfigurationDTO();
        $config->setName('name');
        $config->setValue('valueTest');

        $mock = Mockery::mock(ConfigurationRepository::class);
        $mock->shouldReceive('findByName')->andReturn([$config]);
        $this->app->instance(ConfigurationRepository::class, $mock);

        $serviceMock = Mockery::mock(ConfigurationService::class);
        $serviceMock->shouldReceive('findConfigByName')->andReturn($config);
        $this->app->instance(ConfigurationService::class, $serviceMock);

        $service = new ConfigurationService($mock);
        $result = $service->findConfigValue('name');

        $this->assertEquals('valueTest', $result);
    }

    public function testFindConfigByName()
    {
        $config = new ConfigurationDTO();
        $config->setName('name');
        $config->setValue('valueTest');

        $mock = Mockery::mock(ConfigurationRepository::class);
        $mock->shouldReceive('findByName')->once()->andReturn([$config]);
        $this->app->instance(ConfigurationRepository::class, $mock);

        $service = new ConfigurationService($mock);
        $result = $service->findConfigByName('name');

        $this->assertInstanceOf(ConfigurationDTO::class, $result);
        $this->assertEquals('name', $result->getName());
    }
}