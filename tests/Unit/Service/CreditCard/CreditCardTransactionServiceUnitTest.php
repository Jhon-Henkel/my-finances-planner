<?php

namespace Tests\Unit\Service\CreditCard;

use App\DTO\CreditCard\CreditCardDTO;
use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\DTO\InvoiceItemDTO;
use App\Repositories\CreditCard\CreditCardTransactionRepository;
use App\Services\CreditCard\CreditCardMovementService;
use App\Services\CreditCard\CreditCardService;
use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarToolsReal;
use App\VO\InvoiceVO;
use Mockery;
use Tests\Falcon9;

class CreditCardTransactionServiceUnitTest extends Falcon9
{
    public function testGetNextInstallmentOrder()
    {
        $serviceMock = Mockery::mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $invoice = new InvoiceVO();
        $invoice->firstInstallment = 1;
        $invoice->secondInstallment = 2;
        $invoice->thirdInstallment = 3;
        $invoice->fourthInstallment = 4;
        $invoice->fifthInstallment = 5;
        $invoice->sixthInstallment = 6;

        $this->assertEquals('firstInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->firstInstallment = null;

        $this->assertEquals('secondInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->secondInstallment = null;

        $this->assertEquals('thirdInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->thirdInstallment = null;

        $this->assertEquals('fourthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->fourthInstallment = null;

        $this->assertEquals('fifthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->fifthInstallment = null;

        $this->assertEquals('sixthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->sixthInstallment = null;

        $this->assertEquals(null, $serviceMock->getNextInstallmentOrder([$invoice]));
        $this->assertEquals(null, $serviceMock->getNextInstallmentOrder([]));
    }

    public function testGetNextPaymentDateByInstallment()
    {
        $serviceMock = Mockery::mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $mockCalendar = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $mockCalendar->shouldReceive('addMonthInDate')->once()->andReturn('2021-01-01');
        $this->app->instance(CalendarToolsReal::class, $mockCalendar);

        $this->assertEquals('2021-01-01', $serviceMock->getNextPaymentDateByInstallment(1));
    }

    public function testPayInvoice()
    {
        $creditCardTransactionRepositoryMock = Mockery::mock(CreditCardTransactionRepository::class)->makePartial();

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $movementServiceMock->shouldReceive('launchMovementForCreditCardInvoicePay')->once()->andReturnTrue();

        $card = new CreditCardDTO();
        $card->setName('Card Test');

        $creditCardServiceMock = Mockery::mock(CreditCardService::class)->makePartial();
        $creditCardServiceMock->shouldReceive('findById')->once()->andReturn($card);

        $creditCardMovementServiceMock = Mockery::mock(CreditCardMovementService::class)->makePartial();
        $creditCardMovementServiceMock->shouldReceive('insertMovementByTransaction')->times(3)->andReturnTrue();

        $arrayMocks = [
            $creditCardTransactionRepositoryMock,
            $creditCardMovementServiceMock,
            $creditCardServiceMock,
            $movementServiceMock
        ];

        $installmentArray = [10, 20, 30, 40, 50, 60];
        $invoicesReturn = [
            InvoiceVO::makeInvoice(new InvoiceItemDTO(1, 2, 'Test 1', 'Ds Test 1', 10.22, '2022-10-10', 10), $installmentArray, 150.00),
            InvoiceVO::makeInvoice(new InvoiceItemDTO(2, 3, 'Test 2', 'Ds Test 2', 15.26, '2022-11-10', 5), $installmentArray, 150.00),
            InvoiceVO::makeInvoice(new InvoiceItemDTO(3, 4, 'Test 3', 'Ds Test 3', 99.29, '2022-12-10', 1), $installmentArray, 150.00),
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class, $arrayMocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getInvoices')->once()->andReturn($invoicesReturn);
        $serviceMock->shouldReceive('getNextInstallmentOrder')->once()->andReturn('firstInstallment');

        $transactionOne = new CreditCardTransactionDTO();
        $transactionOne->setId(1);
        $transactionOne->setCreditCardId(1);
        $transactionOne->setName('Test 1');
        $transactionOne->setValue(10.22);
        $transactionOne->setInstallments(10);
        $transactionOne->setNextInstallment('2022-10-10');

        $transactionTwo = new CreditCardTransactionDTO();
        $transactionTwo->setId(1);
        $transactionTwo->setCreditCardId(1);
        $transactionTwo->setName('Test 1');
        $transactionTwo->setValue(10.22);
        $transactionTwo->setInstallments(10);
        $transactionTwo->setNextInstallment('2022-10-10');

        $transactionThree = new CreditCardTransactionDTO();
        $transactionThree->setId(1);
        $transactionThree->setCreditCardId(1);
        $transactionThree->setName('Test 1');
        $transactionThree->setValue(10.22);
        $transactionThree->setInstallments(1);
        $transactionThree->setNextInstallment('2022-10-10');

        $serviceMock->shouldReceive('findById')->times(3)->andReturn($transactionOne, $transactionTwo, $transactionThree);
        $serviceMock->shouldReceive('deleteById')->once()->andReturnTrue();
        $serviceMock->shouldReceive('getNextPaymentDateByInstallment')->twice()->andReturn('2022-10-10');
        $serviceMock->shouldReceive('update')->twice()->andReturnTrue();

        $payed = $serviceMock->payInvoice(1, 1);

        $this->assertTrue($payed);
    }
}