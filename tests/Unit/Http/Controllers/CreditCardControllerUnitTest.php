<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CreditCardController;
use App\Resources\CreditCard\CreditCardResource;
use App\Services\CreditCard\CreditCardService;
use Mockery;
use Tests\Falcon9;
use Tests\Unit\Resource\CreditCard\CreditCardResourceUnitTest;

class CreditCardControllerUnitTest extends Falcon9
{
    public function testInsertRules()
    {
        $controllerMock = $this->mock(CreditCardController::class)->makePartial();
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
        $serviceMock = $this->mock(CreditCardService::class)->makePartial();
        $controllerMock = Mockery::mock(CreditCardController::class, [$serviceMock])->makePartial();
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
        $serviceMock = $this->mock(CreditCardService::class)->makePartial();
        $controllerMock = Mockery::mock(CreditCardController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(CreditCardResource::class, $resource);
    }

    public function testGetService()
    {
        $serviceMock = $this->mock(CreditCardService::class)->makePartial();
        $controllerMock = Mockery::mock(CreditCardController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(CreditCardService::class, $service);
    }
}