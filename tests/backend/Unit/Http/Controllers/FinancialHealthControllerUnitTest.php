<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Http\Controllers\FinancialHealthController;
use App\Services\Tools\FinancialHealthService;
use Mockery;
use Monolog\Test\TestCase;

class FinancialHealthControllerUnitTest extends TestCase
{
    public function testGetService()
    {
        $serviceMock = Mockery::mock(FinancialHealthService::class);

        $controller = new FinancialHealthController($serviceMock);
        $service = $controller->getService();

        $this->assertInstanceOf(FinancialHealthService::class, $service);
    }

    public function testGetResource()
    {
        $this->expectException(NotImplementedException::class);

        $serviceMock = Mockery::mock(FinancialHealthService::class);
        $controller = new FinancialHealthController($serviceMock);
        $controller->getResource();
    }
}
