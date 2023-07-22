<?php

namespace Tests\Unit\Service\CreditCard;

use App\Services\CreditCard\CreditCardTransactionService;
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
        $invoice->forthInstallment = 4;
        $invoice->fifthInstallment = 5;
        $invoice->sixthInstallment = 6;

        $this->assertEquals('firstInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->firstInstallment = null;

        $this->assertEquals('secondInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->secondInstallment = null;

        $this->assertEquals('thirdInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->thirdInstallment = null;

        $this->assertEquals('forthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->forthInstallment = null;

        $this->assertEquals('fifthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->fifthInstallment = null;

        $this->assertEquals('sixthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->sixthInstallment = null;

        $this->assertEquals(null, $serviceMock->getNextInstallmentOrder([$invoice]));
        $this->assertEquals(null, $serviceMock->getNextInstallmentOrder([]));
    }
}