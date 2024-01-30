<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\DTO\CreditCard\CreditCardDTO;
use App\Http\Controllers\CreditCardTransactionController;
use App\Resources\CreditCard\CreditCardTransactionResource;
use App\Services\CreditCard\CreditCardService;
use App\Services\CreditCard\CreditCardTransactionService;
use Mockery;
use Tests\backend\Falcon9;

class CreditCardTransactionControllerUnitTest extends Falcon9
{
    public function testInvoices()
    {
        $creditCardService = $this->mock(CreditCardService::class)->makePartial();
        $creditCardService->shouldReceive('findById')->once()->andReturn(new CreditCardDTO());

        $creditCardTransactionServiceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $creditCardTransactionServiceMock->shouldAllowMockingProtectedMethods();
        $creditCardTransactionServiceMock->shouldReceive('getInvoices')->once()->andReturn(['foo']);

        $mocks = [$creditCardTransactionServiceMock, new CreditCardTransactionResource(), $creditCardService];

        $controller = $this->app->make(CreditCardTransactionController::class, $mocks);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->invoices(1));
    }

    public function testPayInvoiceWithExpenseReturn()
    {
        $serviceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('payInvoice')->once()->andReturnTrue();

        $creditCardServiceMock = $this->mock(CreditCardService::class)->makePartial();
        $creditCardServiceMock->shouldReceive('findById')->once()->andReturn(new CreditCardDTO());

        $mocks = [
            $serviceMock,
            new CreditCardTransactionResource(),
            $creditCardServiceMock
        ];

        $controller = $this->app->make(CreditCardTransactionController::class, $mocks);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->payInvoice(1, 2));
    }

    public function testPayInvoiceWithoutExpenseReturn()
    {
        $serviceMock = $this->mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('payInvoice')->once()->andReturnFalse();

        $creditCardServiceMock = $this->mock(CreditCardService::class)->makePartial();
        $creditCardServiceMock->shouldReceive('findById')->once()->andReturn(new CreditCardDTO());

        $mocks = [
            $serviceMock,
            new CreditCardTransactionResource(),
            $creditCardServiceMock
        ];

        $controller = $this->app->make(CreditCardTransactionController::class, $mocks);

        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $controller->payInvoice(1, 2));
    }

    public function testRulesUpdate()
    {
        $mocks = [
            Mockery::mock(CreditCardTransactionService::class)->makePartial(),
            new CreditCardTransactionResource(),
            Mockery::mock(CreditCardService::class)
        ];

        $controllerMock = Mockery::mock(CreditCardTransactionController::class, $mocks)->makePartial();
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
        $mocks = [
            Mockery::mock(CreditCardTransactionService::class)->makePartial(),
            new CreditCardTransactionResource(),
            Mockery::mock(CreditCardService::class)
        ];

        $controllerMock = Mockery::mock(CreditCardTransactionController::class, $mocks)->makePartial();
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
        $mocks = [
            Mockery::mock(CreditCardTransactionService::class)->makePartial(),
            new CreditCardTransactionResource(),
            Mockery::mock(CreditCardService::class)
        ];

        $controllerMock = Mockery::mock(CreditCardTransactionController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(CreditCardTransactionResource::class, $resource);
    }
}