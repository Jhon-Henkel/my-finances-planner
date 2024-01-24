<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Http\Controllers\DashboardController;
use App\Services\DashboardService;
use Mockery;
use Tests\backend\Falcon9;

class DashboardControllerUnitTest extends Falcon9
{
    public function testIndex()
    {
        $dashboardServiceMock = Mockery::mock(DashboardService::class)->makePartial();
        $dashboardServiceMock->shouldAllowMockingProtectedMethods();
        $dashboardServiceMock->shouldReceive('getDashboardData')->once()->andReturn(['foo']);
        $controller = $this->app->make(DashboardController::class, [$dashboardServiceMock]);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->index());
    }
}