<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use PHPUnit\Framework\TestCase;

class WalletControllerUnitTest extends TestCase
{
    public function testRulesUpdate()
    {
        $serviceMock = Mockery::mock('App\Services\WalletService');
        $controllerMock = Mockery::mock('App\Http\Controllers\WalletController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('type', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('required|max:255|min:2|string', $rules['name']);
        $this->assertEquals('required|int', $rules['type']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
    }

    public function testInsertRules()
    {
        $serviceMock = Mockery::mock('App\Services\WalletService');
        $controllerMock = Mockery::mock('App\Http\Controllers\WalletController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('type', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('required|unique:App\Models\WalletModel,name|max:255|min:2|string', $rules['name']);
        $this->assertEquals('required|int', $rules['type']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock('App\Services\WalletService');
        $controllerMock = Mockery::mock('App\Http\Controllers\WalletController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf('App\Services\WalletService', $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock('App\Services\WalletService');
        $controllerMock = Mockery::mock('App\Http\Controllers\WalletController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf('App\Resources\WalletResource', $resource);
    }
}