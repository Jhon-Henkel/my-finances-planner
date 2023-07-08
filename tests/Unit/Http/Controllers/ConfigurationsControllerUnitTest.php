<?php

namespace Tests\Unit\Http\Controllers;

use App\DTO\ConfigurationDTO;
use App\VO\ConfigurationsVO;
use Mockery;
use Tests\Falcon9;

class ConfigurationsControllerUnitTest extends Falcon9
{
    public function testRulesInsert()
    {
        $controllerMock = $this->mock('App\Http\Controllers\ConfigurationsController')->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertEmpty($rules);
    }

    public function testUpdateRules()
    {
        $controllerMock = $this->mock('App\Http\Controllers\ConfigurationsController')->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('value', $rules);
        $this->assertEquals('required', $rules['value']);
    }

    public function testGetService()
    {
        $serviceMock = $this->mock('App\Services\ConfigurationService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\ConfigurationsController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf('App\Services\ConfigurationService', $service);
    }

    public function testGetResource()
    {
        $serviceMock = $this->mock('App\Services\ConfigurationService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\ConfigurationsController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf('App\Resources\ConfigurationResource', $resource);
    }
}