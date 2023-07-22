<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\FutureSpentController;
use App\Resources\FutureSpentResource;
use App\Services\FutureSpentService;
use Mockery;
use Tests\Falcon9;

class FutureSpentControllerUnitTest extends Falcon9
{
    public function testInsertRules()
    {
        $serviceMock = Mockery::mock(FutureSpentService::class);
        $controllerMock = Mockery::mock(FutureSpentController::class, [$serviceMock])->makePartial();
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
        $serviceMock = Mockery::mock(FutureSpentService::class);
        $controllerMock = Mockery::mock(FutureSpentController::class, [$serviceMock])->makePartial();
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
        $serviceMock = Mockery::mock(FutureSpentService::class);
        $controllerMock = Mockery::mock(FutureSpentController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(FutureSpentService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(FutureSpentService::class);
        $controllerMock = Mockery::mock(FutureSpentController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(FutureSpentResource::class, $resource);
    }
}