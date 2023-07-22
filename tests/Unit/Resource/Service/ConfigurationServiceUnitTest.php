<?php

namespace Tests\Unit\Resource\Service;

use App\DTO\ConfigurationDTO;
use App\Services\ConfigurationService;
use Mockery;
use Tests\Falcon9;

class ConfigurationServiceUnitTest extends Falcon9
{
    public function testFindConfigValue()
    {
        $config = new ConfigurationDTO();
        $config->setName('name');
        $config->setValue('valueTest');

        $mock = Mockery::mock('App\Repositories\ConfigurationRepository');
        $mock->shouldReceive('findByName')->andReturn([$config]);
        $this->app->instance('App\Repositories\ConfigurationRepository', $mock);

        $serviceMock = Mockery::mock('App\Services\ConfigurationService');
        $serviceMock->shouldReceive('findConfigByName')->andReturn($config);
        $this->app->instance('App\Services\ConfigurationService', $serviceMock);

        $service = new ConfigurationService($mock);
        $result = $service->findConfigValue('name');

        $this->assertEquals('valueTest', $result);
    }

    public function testFindConfigByName()
    {
        $config = new ConfigurationDTO();
        $config->setName('name');
        $config->setValue('valueTest');

        $mock = Mockery::mock('App\Repositories\ConfigurationRepository');
        $mock->shouldReceive('findByName')->once()->andReturn([$config]);
        $this->app->instance('App\Repositories\ConfigurationRepository', $mock);

        $service = new ConfigurationService($mock);
        $result = $service->findConfigByName('name');

        $this->assertInstanceOf(ConfigurationDTO::class, $result);
        $this->assertEquals('name', $result->getName());
    }
}