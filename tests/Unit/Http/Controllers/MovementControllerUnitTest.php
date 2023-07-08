<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Tests\Falcon9;

class MovementControllerUnitTest extends Falcon9
{
    public function testInsertRules()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('description', $rules);
        $this->assertArrayHasKey('type', $rules);
        $this->assertArrayHasKey('walletId', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('max:255|min:2|string', $rules['description']);
        $this->assertEquals('required|int', $rules['type']);
        $this->assertEquals('required|int|exists:App\Models\WalletModel,id', $rules['walletId']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
    }

    public function testUpdateRules()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('description', $rules);
        $this->assertArrayHasKey('type', $rules);
        $this->assertArrayHasKey('walletId', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('max:255|min:2|string', $rules['description']);
        $this->assertEquals('required|int', $rules['type']);
        $this->assertEquals('required|int|exists:App\Models\WalletModel,id', $rules['walletId']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf('App\Services\MovementService', $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf('App\Resources\MovementResource', $resource);
    }
}