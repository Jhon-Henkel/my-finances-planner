<?php

namespace Tests\Unit\Service;

use App\DTO\DatePeriodDTO;
use App\DTO\MonthlyClosingDTO;
use App\Enums\MonthlyCLosingEnum;
use App\Exceptions\FilterException;
use App\Repositories\MonthlyClosingRepository;
use App\Services\MonthlyClosingService;
use App\VO\Chart\ChartDataVO;
use Mockery;
use Tests\TestCase;

class MonthlyClosingServiceUnitTest extends TestCase
{
    public function testGetFilterThisYear()
    {
        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getThisYear')->once()->andReturn('2021');

        $filter = $serviceMock->getFilter(MonthlyCLosingEnum::THIS_YEAR);

        $this->assertInstanceOf(DatePeriodDTO::class, $filter);
        $this->assertEquals('2021-01-01 00:00:00', $filter->getStartDate());
        $this->assertEquals('2021-12-31 23:59:59', $filter->getEndDate());
    }

    public function testGetFilterLastYear()
    {
        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getThisYear')->once()->andReturn('2021');

        $filter = $serviceMock->getFilter(MonthlyCLosingEnum::LAST_YEAR);

        $this->assertInstanceOf(DatePeriodDTO::class, $filter);
        $this->assertEquals('2020-01-01 00:00:00', $filter->getStartDate());
        $this->assertEquals('2020-12-31 23:59:59', $filter->getEndDate());
    }

    public function testGetFilterLastFiveYears()
    {
        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getThisYear')->once()->andReturn('2021');

        $filter = $serviceMock->getFilter(MonthlyCLosingEnum::LAST_FIVE_YEARS);

        $this->assertInstanceOf(DatePeriodDTO::class, $filter);
        $this->assertEquals('2016-01-01 00:00:00', $filter->getStartDate());
        $this->assertEquals('2021-12-31 23:59:59', $filter->getEndDate());
    }

    public function testGetFilterException()
    {
        $this->expectExceptionMessage('Opção de filtro inválida');
        $this->expectException(FilterException::class);

        $serviceMock = Mockery::mock(MonthlyClosingService::class )->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getThisYear')->once()->andReturn('2021');

        $serviceMock->getFilter(999);
    }

    public function testFindByFilter()
    {
        $repositoryMock = Mockery::mock(MonthlyClosingRepository::class )->makePartial();
        $repositoryMock->shouldReceive('findByPeriod')->once()->andReturn([]);

        $datePeriod = new DatePeriodDTO('2021-01-01 00:00:00', '2021-12-31 23:59:59');
        $serviceMock = Mockery::mock(MonthlyClosingService::class, [$repositoryMock])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getFilter')->once()->andReturn($datePeriod);

        $result = $serviceMock->findByFilter(MonthlyCLosingEnum::THIS_YEAR);

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
}