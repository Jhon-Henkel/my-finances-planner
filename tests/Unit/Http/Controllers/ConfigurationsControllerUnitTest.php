<?php

namespace Tests\Unit\Http\Controllers;

use App\DTO\ConfigurationDTO;
use App\Http\Controllers\ConfigurationsController;
use App\Resources\ConfigurationResource;
use App\Services\ConfigurationService;
use App\VO\ConfigurationsVO;
use Mockery;
use Tests\Falcon9;

class ConfigurationsControllerUnitTest extends Falcon9
{
    public function testRulesInsert()
    {
        $controllerMock = $this->mock(ConfigurationsController::class)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertEmpty($rules);
    }

    public function testUpdateRules()
    {
        $controllerMock = $this->mock(ConfigurationsController::class)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('value', $rules);
        $this->assertEquals('required', $rules['value']);
    }

    public function testGetService()
    {
        $serviceMock = $this->mock(ConfigurationService::class)->makePartial();
        $controllerMock = Mockery::mock(ConfigurationsController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(ConfigurationService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = $this->mock(ConfigurationService::class)->makePartial();
        $controllerMock = Mockery::mock(ConfigurationsController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(ConfigurationResource::class, $resource);
    }
}