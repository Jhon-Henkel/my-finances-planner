<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\PanoramaController;
use App\Services\PanoramaService;
use Mockery;
use Tests\Falcon9;

class PanoramaControllerUnitTest extends Falcon9
{
    public function testGetPanoramaData()
    {
        $serviceMock = Mockery::mock(PanoramaService::class);
        $controllerMock = Mockery::mock(PanoramaController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $serviceMock->shouldReceive('getPanoramaData')->once()->andReturn(['foo']);

        $result = $controllerMock->getPanoramaData();

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $result);
    }
}