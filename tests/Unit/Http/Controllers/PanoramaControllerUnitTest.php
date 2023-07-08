<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Tests\Falcon9;

class PanoramaControllerUnitTest extends Falcon9
{
    public function testGetPanoramaData()
    {
        $serviceMock = Mockery::mock('App\Services\PanoramaService');
        $controllerMock = Mockery::mock('App\Http\Controllers\PanoramaController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $serviceMock->shouldReceive('getPanoramaData')->once()->andReturn(['foo']);

        $result = $controllerMock->getPanoramaData();

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $result);
    }
}