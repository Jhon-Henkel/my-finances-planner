<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CronController;
use App\Services\CronService;
use Mockery;
use Tests\Falcon9;

class CronControllerUnitTest extends Falcon9
{
    public function testGetService()
    {
        $serviceMock = Mockery::mock(CronService::class);

        $controllerMock = Mockery::mock(CronController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CronService::class, $controllerMock->getService());
    }
}