<?php

namespace Tests\Unit\Service;

use App\DTO\InvoiceItemDTO;
use App\VO\InvoiceVO;
use Mockery;
use Tests\Falcon9;

class PanoramaServiceUnitTest extends Falcon9
{
    public function testGetPanoramaData()
    {
        $serviceMock = Mockery::mock('App\Services\PanoramaService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getTotalFutureExpenses')->times(2)->andReturn([]);
        $serviceMock->shouldReceive('getTotalFutureGains')->once()->andReturn(new InvoiceVO());
        $serviceMock->shouldReceive('getTotalCreditCardExpenses')->once()->andReturn(new InvoiceVO());
        $serviceMock->shouldReceive('getWalletInvoiceData')->once()->andReturn(10.50);
        $serviceMock->shouldReceive('getTotalLeft')->once()->andReturn(new InvoiceVO());

        $result = $serviceMock->getPanoramaData();

        $this->assertIsArray($result);
        $this->assertCount(6, $result);
        $this->assertArrayHasKey('totalWalletValue', $result);
        $this->assertArrayHasKey('futureExpenses', $result);
        $this->assertArrayHasKey('totalFutureExpenses', $result);
        $this->assertArrayHasKey('totalFutureGains', $result);
        $this->assertArrayHasKey('totalCreditCardExpenses', $result);
        $this->assertArrayHasKey('totalLeft', $result);
    }

    public function testGetWalletInvoiceData()
    {
        $serviceMock = Mockery::mock('App\Services\PanoramaService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $walletServiceMock = Mockery::mock('App\Services\WalletService');
        $walletServiceMock->shouldReceive('getTotalWalletValue')->once()->andReturn(10.50);
        $this->app->instance('App\Services\WalletService', $walletServiceMock);

        $result = $serviceMock->getWalletInvoiceData();

        $this->assertIsFloat($result);
        $this->assertEquals(10.50, $result);
    }

    public function testGetTotalFutureExpenses()
    {
        $serviceMock = Mockery::mock('App\Services\PanoramaService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $invoiceServiceMock = Mockery::mock('App\Services\FutureSpentService');
        $invoiceServiceMock->shouldReceive('getNextSixMonthsFutureSpent')->once()->andReturn([]);
        $this->app->instance('App\Services\FutureSpentService', $invoiceServiceMock);

        $result = $serviceMock->getTotalFutureExpenses();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testGetTotalFutureGains()
    {
        $serviceMock = Mockery::mock('App\Services\PanoramaService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $gainServiceMock = Mockery::mock('App\Services\FutureGainService');
        $gainServiceMock->shouldReceive('getNextSixMonthsFutureGain')->once()->andReturn([]);
        $this->app->instance('App\Services\FutureGainService', $gainServiceMock);

        $result = $serviceMock->getTotalFutureGains();

        $this->assertInstanceOf(InvoiceVO::class, $result);
    }

    public function testGetTotalCreditCardExpenses()
    {
        $item = new InvoiceVO();
        $item->countId = 1;
        $item->countName = 'Teste';
        $item->firstInstallment = 10.50;
        $item->secondInstallment = 10.50;
        $item->thirdInstallment = 10.50;
        $item->forthInstallment = 10.50;
        $item->fifthInstallment = 10.50;
        $item->sixthInstallment = 10.50;

        $serviceMock = Mockery::mock('App\Services\PanoramaService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $invoiceServiceMock = Mockery::mock('App\Services\CreditCardTransactionService');
        $invoiceServiceMock->shouldReceive('getAllCardsInvoices')->once()->andReturn([$item]);
        $this->app->instance('App\Services\CreditCardTransactionService', $invoiceServiceMock);

        $result = $serviceMock->getTotalCreditCardExpenses();

        $this->assertInstanceOf(InvoiceVO::class, $result);
    }

    public function testGetTotalLeft()
    {
        $item = new InvoiceVO();
        $item->countId = 1;
        $item->countName = 'Teste';
        $item->firstInstallment = 10.50;
        $item->secondInstallment = 10.50;
        $item->thirdInstallment = 10.50;
        $item->forthInstallment = 10.50;
        $item->fifthInstallment = 10.50;
        $item->sixthInstallment = 10.50;

        $serviceMock = Mockery::mock('App\Services\PanoramaService')->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $result = $serviceMock->getTotalLeft($item, $item, $item);

        $this->assertInstanceOf(InvoiceVO::class, $result);
    }
}