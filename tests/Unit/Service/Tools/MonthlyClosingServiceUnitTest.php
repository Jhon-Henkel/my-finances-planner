<?php

namespace Tests\Unit\Service\Tools;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\Mail\MailMessageDTO;
use App\DTO\Movement\MovementSumValuesDTO;
use App\DTO\Tools\MonthlyClosingDTO;
use App\Enums\MonthlyCLosingEnum;
use App\Exceptions\FilterException;
use App\Models\MonthlyClosing;
use App\Repositories\Tools\MonthlyClosingRepository;
use App\Resources\Tools\MonthlyClosingResource;
use App\Services\FutureGainService;
use App\Services\FutureSpentService;
use App\Services\Movement\MovementService;
use App\Services\Tools\MonthlyClosingService;
use App\Tools\Calendar\CalendarToolsReal;
use App\VO\Chart\ChartDataVO;
use Mockery;
use Tests\Falcon9;

class MonthlyClosingServiceUnitTest extends Falcon9
{
    public function testGetFilterThisYear()
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisYear')->andReturn('2021');
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $filter = $serviceMock->getFilter(MonthlyCLosingEnum::THIS_YEAR);

        $this->assertInstanceOf(DatePeriodDTO::class, $filter);
        $this->assertEquals('2021-01-01 00:00:00', $filter->getStartDate());
        $this->assertEquals('2021-12-31 23:59:59', $filter->getEndDate());
    }

    public function testGetFilterLastYear()
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisYear')->andReturn('2021');
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $filter = $serviceMock->getFilter(MonthlyCLosingEnum::LAST_YEAR);

        $this->assertInstanceOf(DatePeriodDTO::class, $filter);
        $this->assertEquals('2020-01-01 00:00:00', $filter->getStartDate());
        $this->assertEquals('2020-12-31 23:59:59', $filter->getEndDate());
    }

    public function testGetFilterLastFiveYears()
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisYear')->andReturn('2021');
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $filter = $serviceMock->getFilter(MonthlyCLosingEnum::LAST_FIVE_YEARS);

        $this->assertInstanceOf(DatePeriodDTO::class, $filter);
        $this->assertEquals('2016-01-01 00:00:00', $filter->getStartDate());
        $this->assertEquals('2021-12-31 23:59:59', $filter->getEndDate());
    }

    public function testGetFilterException()
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisYear')->andReturn('2021');
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $this->expectExceptionMessage('Opção de filtro inválida');
        $this->expectException(FilterException::class);

        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $serviceMock->getFilter(999);
    }

    public function testFindByFilter()
    {
        $modelMock = Mockery::mock(MonthlyClosing::class);

        $mocks = [$modelMock, new MonthlyClosingResource()];
        $repositoryMock = Mockery::mock(MonthlyClosingRepository::class, $mocks)->makePartial();
        $repositoryMock->shouldReceive('findByPeriodAndTenantId')->once()->andReturn([]);

        $datePeriod = new DatePeriodDTO('2021-01-01 00:00:00', '2021-12-31 23:59:59');
        $serviceMock = Mockery::mock(MonthlyClosingService::class, [$repositoryMock])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getFilter')->once()->andReturn($datePeriod);

        $result = $serviceMock->findByFilter(MonthlyCLosingEnum::THIS_YEAR, 1);

        $this->assertIsArray($result);
    }

    public function testAddChartData()
    {
        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $dataOne = new MonthlyClosingDTO(1, 500, 1000, 2000, 100, 100, '2021-01-01 00:00:00', '2021-01-31 23:59:59');
        $dataTwo = new MonthlyClosingDTO(2, 100, 200, 300, 400, 500, '2021-02-01 00:00:00', '2021-02-28 23:59:59');
        $data = [$dataOne, $dataTwo];

        $result = $serviceMock->addChartData($data);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('chartData', $result);
        $this->assertIsArray($result['data']);
        $this->assertCount(2, $result['data']);
        $this->assertInstanceOf(MonthlyClosingDTO::class, $result['data'][0]);
        $this->assertInstanceOf(MonthlyClosingDTO::class, $result['data'][1]);
        $this->assertInstanceOf(ChartDataVO::class, $result['chartData']);
    }

    public function testUpdateLastMonthlyClosing()
    {
        $monthlyClosing = new MonthlyClosingDTO(
            1,
            100,
            200,
            null,
            null,
            null,
            '2021-01-01 00:00:00',
            '2021-01-31 23:59:59'
        );
        $repositoryMock = Mockery::mock(MonthlyClosingRepository::class )->makePartial();
        $repositoryMock->shouldReceive('update')->once()->andReturn(function (int $id, MonthlyClosingDTO $lastClosing) {
            Falcon9::assertEquals(1, $id);
            Falcon9::assertInstanceOf(MonthlyClosingDTO::class, $lastClosing);
            Falcon9::assertEquals(100, $lastClosing->getRealEarnings());
            Falcon9::assertEquals(200, $lastClosing->getRealExpenses());
            Falcon9::assertEquals(100, $lastClosing->getRealBalance());
            Falcon9::assertEquals(100, $lastClosing->getPredictedEarnings());
            Falcon9::assertEquals(200, $lastClosing->getPredictedExpenses());
        });

        $sumValues = new MovementSumValuesDTO(100, 200, 100);
        $movementServiceMock = Mockery::mock(MovementService::class )->makePartial();
        $movementServiceMock->shouldReceive('getSumValuesForPeriod')->once()->andReturn($sumValues);
        $this->app->instance(MovementService::class, $movementServiceMock);

        $serviceMock = Mockery::mock(MonthlyClosingService::class, [$repositoryMock])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $serviceMock->updateLastMonthlyClosing($monthlyClosing, 1);
    }

    public function testCreateMonthlyClosing()
    {
        $futureGainServiceMock = Mockery::mock(FutureGainService::class )->makePartial();
        $futureGainServiceMock->shouldReceive('getThisMonthFutureGainSum')->once()->andReturn(100);
        $this->app->instance(FutureGainService::class, $futureGainServiceMock);

        $futureSpentServiceMock = Mockery::mock(FutureSpentService::class )->makePartial();
        $futureSpentServiceMock->shouldReceive('getThisMonthFutureSpentSum')->once()->andReturn(200);
        $this->app->instance(FutureSpentService::class, $futureSpentServiceMock);

        $monthlyClosingServiceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $monthlyClosingServiceMock->shouldAllowMockingProtectedMethods();
        $monthlyClosing = $monthlyClosingServiceMock->createMonthlyClosing(1);

        $this->assertInstanceOf(MonthlyClosingDTO::class, $monthlyClosing);
        $this->assertEquals(100, $monthlyClosing->getPredictedEarnings());
        $this->assertEquals(200, $monthlyClosing->getPredictedExpenses());
    }

    public function testGenerateMailMonthlyClosingDone()
    {
        $monthlyClosingServiceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $monthlyClosingServiceMock->shouldAllowMockingProtectedMethods();
        $mail = $monthlyClosingServiceMock->generateMailMonthlyClosingDone('test@test.com', 'Fulano Da Silva');

        $this->assertInstanceOf(MailMessageDTO::class, $mail);
        $this->assertEquals('test@test.com', $mail->getAddressee());
        $this->assertEquals('Fulano Da Silva', $mail->getAddresseeName());
        $this->assertEquals('Fechamento Mensal Realizado', $mail->getSubject());
        $this->assertEquals('emails.monthlyClosingDone', $mail->getTempleteFile());
        $this->assertIsArray($mail->getParams());
        $this->assertCount(2, $mail->getParams());
        $this->assertArrayHasKey('link', $mail->getParams());
        $this->assertArrayHasKey('name', $mail->getParams());
    }
}