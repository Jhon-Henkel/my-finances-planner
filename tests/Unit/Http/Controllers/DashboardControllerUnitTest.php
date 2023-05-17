<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;

class DashboardControllerUnitTest extends TestCase
{
    public function testIndex()
    {
        $dashboardServiceMock = $this->mock('App\Services\DashboardService')->makePartial();
        $dashboardServiceMock->shouldAllowMockingProtectedMethods();
        $dashboardServiceMock->shouldReceive('getDashboardData')->once()->andReturn(['foo']);
        $controller = $this->app->make('App\Http\Controllers\DashboardController', [$dashboardServiceMock]);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->index());
    }
}