<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Http\Controllers\FutureSpentController;
use App\Resources\FutureSpentResource;
use App\Services\FutureMovement\FutureSpentService;
use Mockery;
use Tests\backend\Falcon9;

class FutureSpentControllerUnitTest extends Falcon9
{
    public function testGetService()
    {
        $serviceMock = Mockery::mock(FutureSpentService::class);
        $mocks = [$serviceMock, new FutureSpentResource()];
        $controllerMock = Mockery::mock(FutureSpentController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(FutureSpentService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(FutureSpentService::class);
        $mocks = [$serviceMock, new FutureSpentResource()];
        $controllerMock = Mockery::mock(FutureSpentController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(FutureSpentResource::class, $resource);
    }
}
