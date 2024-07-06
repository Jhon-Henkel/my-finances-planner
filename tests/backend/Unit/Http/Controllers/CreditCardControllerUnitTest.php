<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Http\Controllers\CreditCardController;
use App\Resources\CreditCard\CreditCardResource;
use App\Services\CreditCard\CreditCardService;
use Mockery;
use Tests\backend\Falcon9;

class CreditCardControllerUnitTest extends Falcon9
{
    public function testInsertRules()
    {
        $controllerMock = Mockery::mock(CreditCardController::class)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('limit', $rules);
        $this->assertArrayHasKey('dueDate', $rules);
        $this->assertArrayHasKey('closingDay', $rules);
        $this->assertEquals('required|string|unique:App\Models\CreditCard,name', $rules['name']);
        $this->assertEquals('required|numeric', $rules['limit']);
        $this->assertEquals('required|integer|between:1,31', $rules['dueDate']);
        $this->assertEquals('required|integer|between:1,31', $rules['closingDay']);
    }

    public function testUpdateRules()
    {
        $serviceMock = Mockery::mock(CreditCardService::class, )->makePartial();

        $mocks = [$serviceMock, new CreditCardResource()];
        $controllerMock = Mockery::mock(CreditCardController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('limit', $rules);
        $this->assertArrayHasKey('dueDate', $rules);
        $this->assertArrayHasKey('closingDay', $rules);
        $this->assertEquals('required|string', $rules['name']);
        $this->assertEquals('required|numeric', $rules['limit']);
        $this->assertEquals('required|integer|between:1,31', $rules['dueDate']);
        $this->assertEquals('required|integer|between:1,31', $rules['closingDay']);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(CreditCardService::class, )->makePartial();

        $mocks = [$serviceMock, new CreditCardResource()];
        $controllerMock = Mockery::mock(CreditCardController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(CreditCardResource::class, $resource);
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock(CreditCardService::class, )->makePartial();

        $mocks = [$serviceMock, new CreditCardResource()];
        $controllerMock = Mockery::mock(CreditCardController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(CreditCardService::class, $service);
    }
}
