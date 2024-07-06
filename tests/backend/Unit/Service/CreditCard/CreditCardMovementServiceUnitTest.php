<?php

namespace Tests\backend\Unit\Service\CreditCard;

use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\DTO\Date\DatePeriodDTO;
use App\Repositories\CreditCard\CreditCardMovementRepository;
use App\Resources\CreditCard\CreditCardMovementResource;
use App\Services\CreditCard\CreditCardMovementService;
use App\Tools\Calendar\CalendarToolsReal;
use Mockery;
use Tests\backend\Falcon9;

class CreditCardMovementServiceUnitTest extends Falcon9
{
    public function testGetRepository()
    {
        $repositoryMock = Mockery::mock(CreditCardMovementRepository::class);
        $resource = new CreditCardMovementResource();
        $serviceMock = Mockery::mock(CreditCardMovementService::class, [$repositoryMock, $resource])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCardMovementRepository::class, $serviceMock->getRepository());
    }

    public function testGetResource()
    {
        $resource = new CreditCardMovementResource();
        $repositoryMock = Mockery::mock(CreditCardMovementRepository::class);
        $serviceMock = Mockery::mock(CreditCardMovementService::class, [$repositoryMock, $resource])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCardMovementResource::class, $serviceMock->getResource());
    }

    public function testInsertMovementByTransaction()
    {
        $resource = new CreditCardMovementResource();
        $repositoryMock = Mockery::mock(CreditCardMovementRepository::class);
        $serviceMock = Mockery::mock(CreditCardMovementService::class, [$repositoryMock, $resource])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('insert')->once()->andReturnTrue();

        $transaction = new CreditCardTransactionDTO();
        $transaction->setName('Test');
        $transaction->setValue(100);

        $serviceMock->insertMovementByTransaction($transaction, 1);
    }

    public function testFindByPeriod()
    {
        $resource = Mockery::mock(CreditCardMovementResource::class);
        $resource->shouldReceive('convertCreditCardMovementsToMovements')->once()->andReturn([1 => 2]);

        $repositoryMock = Mockery::mock(CreditCardMovementRepository::class);
        $repositoryMock->shouldReceive('findByPeriod')->once()->andReturn([]);

        $serviceMock = Mockery::mock(CreditCardMovementService::class, [$repositoryMock, $resource])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $datePeriod = new DatePeriodDTO('2021-01-01', '2021-01-31');

        $mockCalendar = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $mockCalendar->shouldReceive('makeDateRangeByDefaultFilterParams')->once()->andReturn($datePeriod);
        $this->app->instance(CalendarToolsReal::class, $mockCalendar);

        $this->assertEquals([1 => 2], $serviceMock->findByPeriod([]));
    }
}
