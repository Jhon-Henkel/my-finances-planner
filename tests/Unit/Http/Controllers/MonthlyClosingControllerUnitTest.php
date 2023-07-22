<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Tests\Falcon9;

class MonthlyClosingControllerUnitTest extends Falcon9
{
    public function testRulesInsert()
    {
        $controllerMock = $this->mock('App\Http\Controllers\MonthlyClosingController')->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('predicted_earnings', $rules);
        $this->assertArrayHasKey('predicted_expenses', $rules);
        $this->assertArrayHasKey('real_earnings', $rules);
        $this->assertArrayHasKey('real_expenses', $rules);
        $this->assertArrayHasKey('balance', $rules);
        $this->assertEquals('required|decimal:0,2', $rules['predicted_earnings']);
        $this->assertEquals('required|decimal:0,2', $rules['predicted_expenses']);
        $this->assertEquals('decimal:0,2', $rules['real_earnings']);
        $this->assertEquals('decimal:0,2', $rules['real_expenses']);
        $this->assertEquals('decimal:0,2', $rules['balance']);
    }

    public function testUpdateRules()
    {
        $controllerMock = $this->mock('App\Http\Controllers\MonthlyClosingController')->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('predicted_earnings', $rules);
        $this->assertArrayHasKey('predicted_expenses', $rules);
        $this->assertArrayHasKey('real_earnings', $rules);
        $this->assertArrayHasKey('real_expenses', $rules);
        $this->assertArrayHasKey('balance', $rules);
        $this->assertEquals('required|decimal:0,2', $rules['predicted_earnings']);
        $this->assertEquals('required|decimal:0,2', $rules['predicted_expenses']);
        $this->assertEquals('required|decimal:0,2', $rules['real_earnings']);
        $this->assertEquals('required|decimal:0,2', $rules['real_expenses']);
        $this->assertEquals('required|decimal:0,2', $rules['balance']);
    }

    public function testGetService()
    {
        $serviceMock = $this->mock('App\Services\Tools\MonthlyClosingService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\MonthlyClosingController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf('App\Services\Tools\MonthlyClosingService', $service);    }

    public function testGetResource()
    {
        $serviceMock = $this->mock('App\Services\Tools\MonthlyClosingService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\MonthlyClosingController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf('App\Resources\Tools\MonthlyClosingResource', $resource);
    }
}