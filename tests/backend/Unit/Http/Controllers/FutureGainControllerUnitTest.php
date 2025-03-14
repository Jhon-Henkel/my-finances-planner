<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Http\Controllers\FutureGainController;
use App\Resources\FutureGainResource;
use App\Services\FutureMovement\FutureGainService;
use Mockery;
use Tests\backend\Falcon9;

class FutureGainControllerUnitTest extends Falcon9
{
    public function testInsertRules()
    {
        $serviceMock = Mockery::mock(FutureGainService::class);
        $mocks = [$serviceMock, new FutureGainResource()];
        $controllerMock = Mockery::mock(FutureGainController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('description', $rules);
        $this->assertArrayHasKey('walletId', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertArrayHasKey('installments', $rules);
        $this->assertArrayHasKey('forecast', $rules);
        $this->assertEquals('required|max:255|string', $rules['description']);
        $this->assertEquals('required|int|exists:App\Models\WalletModel,id', $rules['walletId']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
        $this->assertEquals('required|int', $rules['installments']);
        $this->assertEquals('required|date', $rules['forecast']);
    }

    public function testUpdateRules()
    {
        $serviceMock = Mockery::mock(FutureGainService::class);
        $mocks = [$serviceMock, new FutureGainResource()];
        $controllerMock = Mockery::mock(FutureGainController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('description', $rules);
        $this->assertArrayHasKey('walletId', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertArrayHasKey('installments', $rules);
        $this->assertArrayHasKey('forecast', $rules);
        $this->assertEquals('required|max:255|string', $rules['description']);
        $this->assertEquals('required|int|exists:App\Models\WalletModel,id', $rules['walletId']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
        $this->assertEquals('required|int', $rules['installments']);
        $this->assertEquals('required|date', $rules['forecast']);
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock(FutureGainService::class);
        $mocks = [$serviceMock, new FutureGainResource()];
        $controllerMock = Mockery::mock(FutureGainController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(FutureGainService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(FutureGainService::class);
        $mocks = [$serviceMock, new FutureGainResource()];
        $controllerMock = Mockery::mock(FutureGainController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(FutureGainResource::class, $resource);
    }
}
