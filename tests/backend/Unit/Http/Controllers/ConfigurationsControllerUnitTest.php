<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Http\Controllers\ConfigurationsController;
use App\Resources\ConfigurationResource;
use App\Services\ConfigurationService;
use Mockery;
use Tests\backend\Falcon9;

class ConfigurationsControllerUnitTest extends Falcon9
{
    public function testRulesInsert()
    {
        $serviceMock = Mockery::mock(ConfigurationService::class)->makePartial();

        $mocks = [$serviceMock, new ConfigurationResource()];
        $controllerMock = Mockery::mock(ConfigurationsController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertEmpty($rules);
    }

    public function testUpdateRules()
    {
        $serviceMock = Mockery::mock(ConfigurationService::class)->makePartial();

        $mocks = [$serviceMock, new ConfigurationResource()];
        $controllerMock = Mockery::mock(ConfigurationsController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('value', $rules);
        $this->assertEquals('required', $rules['value']);
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock(ConfigurationService::class)->makePartial();

        $mocks = [$serviceMock, new ConfigurationResource()];
        $controllerMock = Mockery::mock(ConfigurationsController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(ConfigurationService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(ConfigurationService::class)->makePartial();

        $mocks = [$serviceMock, new ConfigurationResource()];
        $controllerMock = Mockery::mock(ConfigurationsController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(ConfigurationResource::class, $resource);
    }
}
