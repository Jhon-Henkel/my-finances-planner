<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Tests\Falcon9;

class CreditCardTransactionControllerUnitTest extends Falcon9
{
    public function testInvoices()
    {
        $serviceMock = $this->mock('App\Services\CreditCard\CreditCardTransactionService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getInvoices')->once()->andReturn(['foo']);
        $controller = $this->app->make('App\Http\Controllers\CreditCardTransactionController', [$serviceMock]);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->invoices(1));
    }

    public function testPayInvoiceWithExpenseReturn()
    {
        $serviceMock = $this->mock('App\Services\CreditCard\CreditCardTransactionService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('payInvoice')->once()->andReturnTrue();
        $controller = $this->app->make('App\Http\Controllers\CreditCardTransactionController', [$serviceMock]);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->payInvoice(1, 2));
    }

    public function testPayInvoiceWithoutExpenseReturn()
    {
        $serviceMock = $this->mock('App\Services\CreditCard\CreditCardTransactionService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('payInvoice')->once()->andReturnFalse();
        $controller = $this->app->make('App\Http\Controllers\CreditCardTransactionController', [$serviceMock]);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->payInvoice(1, 2));
    }

    public function testRulesUpdate()
    {
        $serviceMock = $this->mock('App\Services\CreditCard\CreditCardTransactionService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\CreditCardTransactionController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('creditCardId', $rules);
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('value', $rules);
        $this->assertArrayHasKey('installments', $rules);
        $this->assertArrayHasKey('nextInstallment', $rules);
        $this->assertEquals('required|integer|exists:App\Models\CreditCard,id', $rules['creditCardId']);
        $this->assertEquals('required|string|max:255', $rules['name']);
        $this->assertEquals('required|numeric', $rules['value']);
        $this->assertEquals('required|integer', $rules['installments']);
        $this->assertEquals('required|string', $rules['nextInstallment']);
    }

    public function testRulesInsert()
    {
        $serviceMock = $this->mock('App\Services\CreditCard\CreditCardTransactionService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\CreditCardTransactionController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('creditCardId', $rules);
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('value', $rules);
        $this->assertArrayHasKey('installments', $rules);
        $this->assertArrayHasKey('nextInstallment', $rules);
        $this->assertEquals('required|integer|exists:App\Models\CreditCard,id', $rules['creditCardId']);
        $this->assertEquals('required|string|max:255', $rules['name']);
        $this->assertEquals('required|numeric', $rules['value']);
        $this->assertEquals('required|integer', $rules['installments']);
        $this->assertEquals('required|string', $rules['nextInstallment']);
    }

    public function testGetResource()
    {
        $serviceMock = $this->mock('App\Services\CreditCard\CreditCardTransactionService')->makePartial();
        $controllerMock = Mockery::mock('App\Http\Controllers\CreditCardTransactionController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf('App\Resources\CreditCard\CreditCardTransactionResource', $resource);
    }
}