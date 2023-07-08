<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Tests\Falcon9;

class CreditCardControllerUnitTest extends Falcon9
{
    public function testInsertRules()
    {
        $controllerMock = $this->mock('App\Http\Controllers\CreditCardController')->makePartial();
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
        $serviceMock = $this->mock('App\Services\CreditCardService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\CreditCardController', [$serviceMock])->makePartial();
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
        $serviceMock = $this->mock('App\Services\CreditCardService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\CreditCardController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf('App\Resources\CreditCardResource', $resource);
    }

    public function testGetService()
    {
        $serviceMock = $this->mock('App\Services\CreditCardService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\CreditCardController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf('App\Services\CreditCardService', $service);
    }
}