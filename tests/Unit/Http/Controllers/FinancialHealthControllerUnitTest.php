<?php

namespace Tests\Unit\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Http\Controllers\FinancialHealthController;
use App\Services\Tools\FinancialHealthService;
use Monolog\Test\TestCase;

class FinancialHealthControllerUnitTest extends TestCase
{
    public function testGetService()
    {
        $controller = new FinancialHealthController(app(FinancialHealthService::class));
        $service = $controller->getService();

        $this->assertInstanceOf(FinancialHealthService::class, $service);
    }

    public function testGetResource()
    {
        $this->expectException(NotImplementedException::class);
        $controller = new FinancialHealthController(app(FinancialHealthService::class));
        $controller->getResource();
    }
}