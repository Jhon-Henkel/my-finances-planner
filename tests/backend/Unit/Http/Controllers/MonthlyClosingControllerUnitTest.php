<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Http\Controllers\MonthlyClosingController;
use App\Resources\Tools\MonthlyClosingResource;
use App\Services\Tools\MonthlyClosingService;
use Mockery;
use Tests\backend\Falcon9;

class MonthlyClosingControllerUnitTest extends Falcon9
{
    public function testRulesInsert()
    {
        $controllerMock = Mockery::mock(MonthlyClosingController::class)->makePartial();
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
        $controllerMock = Mockery::mock(MonthlyClosingController::class)->makePartial();
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
        $serviceMock = Mockery::mock(MonthlyClosingService::class)->makePartial();
        $controllerMock = Mockery::mock(MonthlyClosingController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(MonthlyClosingService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(MonthlyClosingService::class)->makePartial();
        $controllerMock = Mockery::mock(MonthlyClosingController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(MonthlyClosingResource::class, $resource);
    }
}