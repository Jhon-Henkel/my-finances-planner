<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Modules\Wallet\Controller\WalletController;
use App\Modules\Wallet\Resource\WalletResource;
use App\Modules\Wallet\Service\WalletService;
use Mockery;
use PHPUnit\Framework\TestCase;

class WalletControllerUnitTest extends TestCase
{
    public function testRulesUpdate()
    {
        $serviceMock = Mockery::mock(WalletService::class);
        $mocks = [$serviceMock, new WalletResource()];

        $controllerMock = Mockery::mock(WalletController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('required|max:255|min:2|string', $rules['name']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
        $this->assertEquals('boolean', $rules['hide_value']);
        $this->assertEquals('required|boolean', $rules['active']);
    }

    public function testInsertRules()
    {
        $serviceMock = Mockery::mock(WalletService::class);
        $mocks = [$serviceMock, new WalletResource()];

        $controllerMock = Mockery::mock(WalletController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('required|max:255|min:2|string', $rules['name']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
        $this->assertEquals('boolean', $rules['hide_value']);
        $this->assertEquals('required|boolean', $rules['active']);
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock(WalletService::class);
        $mocks = [$serviceMock, new WalletResource()];

        $controllerMock = Mockery::mock(WalletController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(WalletService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(WalletService::class);
        $mocks = [$serviceMock, new WalletResource()];

        $controllerMock = Mockery::mock(WalletController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(WalletResource::class, $resource);
    }
}
