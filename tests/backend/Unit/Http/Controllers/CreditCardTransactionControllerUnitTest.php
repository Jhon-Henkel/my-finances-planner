<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Http\Controllers\CreditCardTransactionController;
use App\Resources\CreditCard\CreditCardTransactionResource;
use App\Services\CreditCard\CreditCardTransactionService;
use Mockery;
use Tests\backend\Falcon9;

class CreditCardTransactionControllerUnitTest extends Falcon9
{
    public function testInvoices()
    {
        $serviceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getInvoices')->once()->andReturn(['foo']);
        $controller = $this->app->make(CreditCardTransactionController::class, [$serviceMock]);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->invoices(1));
    }

    public function testPayInvoiceWithExpenseReturn()
    {
        $serviceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('payInvoice')->once()->andReturnTrue();
        $controller = $this->app->make(CreditCardTransactionController::class, [$serviceMock]);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->payInvoice(1, 2));
    }

    public function testPayInvoiceWithoutExpenseReturn()
    {
        $serviceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('payInvoice')->once()->andReturnFalse();
        $controller = $this->app->make(CreditCardTransactionController::class, [$serviceMock]);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->payInvoice(1, 2));
    }

    public function testRulesUpdate()
    {
        $serviceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $controllerMock = Mockery::mock(CreditCardTransactionController::class, [$serviceMock])->makePartial();
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
        $serviceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $controllerMock = Mockery::mock(CreditCardTransactionController::class, [$serviceMock])->makePartial();
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
        $serviceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $controllerMock = Mockery::mock(CreditCardTransactionController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(CreditCardTransactionResource::class, $resource);
    }
}