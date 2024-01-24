<?php

namespace Tests\backend\Unit\Tools;

use App\DTO\Date\DatePeriodDTO;
use App\Tools\Calendar\CalendarTools;
use App\Tools\Calendar\CalendarToolsReal;
use Exception;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\backend\Falcon9;

class CalendarToolsUnitTest extends Falcon9
{
    public function testSalutationMorningWithName()
    {
        for ($index = 4; $index <= 12; $index++) {
            $salutation = CalendarTools::salutation('Pedro', $index);
            $this->assertEquals('Bom dia Pedro', $salutation);
        }
    }

    public function testSalutationAfternoonWithName()
    {
        for ($index = 13; $index < 19; $index++) {
            $salutation = CalendarTools::salutation('João', $index);
            $this->assertEquals('Boa tarde João', $salutation);
        }
    }

    public function testSalutationNightWithName()
    {
        for ($index = 19; $index <= 24; $index++) {
            $salutation = CalendarTools::salutation('Ana', $index);
            $this->assertEquals('Boa noite Ana', $salutation);
        }
        for ($index = 1; $index < 4; $index++) {
            $salutation = CalendarTools::salutation('Júlia', $index);
            $this->assertEquals('Boa noite Júlia', $salutation);
        }
    }

    public function testSalutationMorningWithOutName()
    {
        for ($index = 4; $index <= 12; $index++) {
            $salutation = CalendarTools::salutation(null, $index);
            $this->assertEquals('Bom dia ', $salutation);
        }
    }

    public function testSalutationAftermoonWithOutName()
    {
        for ($index = 13; $index < 19; $index++) {
            $salutation = CalendarTools::salutation(null, $index);
            $this->assertEquals('Boa tarde ', $salutation);
        }
    }

    public function testSalutationNightWithOutName()
    {
        for ($index = 19; $index <= 24; $index++) {
            $salutation = CalendarTools::salutation(null, $index);
            $this->assertEquals('Boa noite ', $salutation);
        }
        for ($index = 1; $index < 4; $index++) {
            $salutation = CalendarTools::salutation(null, $index);
            $this->assertEquals('Boa noite ', $salutation);
        }
    }

    public function testUsToBrDate()
    {
        $date = CalendarTools::stringUsToBrDate('2022-12-01 15:10:50');

        $this->assertEquals('01/12/2022 15:10:50', $date);
    }

    public function testGetThisMonth()
    {
        $mont = CalendarTools::getDateNow();
        $mont = $mont->format('m');

        $this->assertEquals($mont, CalendarTools::getThisMonth());
    }

    public function testGetThisYear()
    {
        $mont = CalendarTools::getDateNow();
        $mont = $mont->format('Y');

        $this->assertEquals($mont, CalendarTools::getThisYear());
    }

    #[DataProvider("dataProviderTestGetMonthFromDate")]
    public function testGetMonthFromDate(string $date, string $expected)
    {
        $this->assertEquals($expected, CalendarTools::getMonthFromStringDate($date));
    }

    public static function dataProviderTestGetMonthFromDate(): array
    {
        return [
            "testJanuaryMonth" => ["date" => "2022-01-01", "expected" => "01"],
            "testFebruaryMonth" => ["date" => "2022-02-01", "expected" => "02"],
            "testMarchMonth" => ["date" => "2022-03-01", "expected" => "03"],
            "testAprilMonth" => ["date" => "2022-04-01", "expected" => "04"],
            "testMayMonth" => ["date" => "2022-05-01", "expected" => "05"],
            "testJuneMonth" => ["date" => "2022-06-01", "expected" => "06"],
            "testJulyMonth" => ["date" => "2022-07-01", "expected" => "07"],
            "testAugustMonth" => ["date" => "2022-08-01", "expected" => "08"],
            "testSeptemberMonth" => ["date" => "2022-09-01", "expected" => "09"],
            "testOctoberMonth" => ["date" => "2022-10-01", "expected" => "10"],
            "testNovemberMonth" => ["date" => "2022-11-01", "expected" => "11"],
            "testDecemberMonth" => ["date" => "2022-12-01", "expected" => "12"],
        ];
    }

    #[DataProvider("dataProviderTestGetDayFromData")]
    public function testGetDayFromData(string $date, string $expected)
    {
        $this->assertEquals($expected, CalendarTools::getDayFromStringDate($date));
    }

    public static function dataProviderTestGetDayFromData(): array
    {
        return [
            "testDay1" => ["date" => "2022-01-01", "expected" => "01"],
            "testDay2" => ["date" => "2022-01-02", "expected" => "02"],
            "testDay3" => ["date" => "2022-01-03", "expected" => "03"],
            "testDay4" => ["date" => "2022-01-04", "expected" => "04"],
            "testDay5" => ["date" => "2022-01-05", "expected" => "05"],
            "testDay6" => ["date" => "2022-01-06", "expected" => "06"],
            "testDay7" => ["date" => "2022-01-07", "expected" => "07"],
            "testDay8" => ["date" => "2022-01-08", "expected" => "08"],
            "testDay9" => ["date" => "2022-01-09", "expected" => "09"],
            "testDay10" => ["date" => "2022-01-10", "expected" => "10"],
            "testDay11" => ["date" => "2022-01-11", "expected" => "11"],
            "testDay12" => ["date" => "2022-01-12", "expected" => "12"],
            "testDay13" => ["date" => "2022-01-13", "expected" => "13"],
            "testDay14" => ["date" => "2022-01-14", "expected" => "14"],
            "testDay15" => ["date" => "2022-01-15", "expected" => "15"],
            "testDay16" => ["date" => "2022-01-16", "expected" => "16"],
            "testDay17" => ["date" => "2022-01-17", "expected" => "17"],
            "testDay18" => ["date" => "2022-01-18", "expected" => "18"],
            "testDay19" => ["date" => "2022-01-19", "expected" => "19"],
            "testDay20" => ["date" => "2022-01-20", "expected" => "20"],
            "testDay21" => ["date" => "2022-01-21", "expected" => "21"],
            "testDay22" => ["date" => "2022-01-22", "expected" => "22"],
            "testDay23" => ["date" => "2022-01-23", "expected" => "23"],
            "testDay24" => ["date" => "2022-01-24", "expected" => "24"],
            "testDay25" => ["date" => "2022-01-25", "expected" => "25"],
            "testDay26" => ["date" => "2022-01-26", "expected" => "26"],
            "testDay27" => ["date" => "2022-01-27", "expected" => "27"],
            "testDay28" => ["date" => "2022-01-28", "expected" => "28"],
            "testDay29" => ["date" => "2022-01-29", "expected" => "29"],
            "testDay30" => ["date" => "2022-01-30", "expected" => "30"],
            "testDay31" => ["date" => "2022-01-31", "expected" => "31"],
        ];
    }

    #[DataProvider("dataProviderTestGetThisMonthPeriod")]
    public function testGetThisMonthPeriod($expectedDateStart, $expectedDateEnd, $month, $year)
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisMonth')->andReturn($month);
        $calendarMock->shouldReceive('getThisYear')->andReturn($year);

        $date = $calendarMock->getThisMonthPeriod();

        $this->assertEquals($expectedDateStart, $date->getStartDate());
        $this->assertEquals($expectedDateEnd, $date->getEndDate());
    }

    public static function dataProviderTestGetThisMonthPeriod(): array
    {
        return [
            "JanuaryTest" => ["expectedDateStart" => "2022-01-01 00:00:00", "expectedDateEnd" => "2022-01-31 23:59:59", "month" => "01", "year" => "2022"],
            "FebruaryTest" => ["expectedDateStart" => "2022-02-01 00:00:00", "expectedDateEnd" => "2022-02-28 23:59:59", "month" => "02", "year" => "2022"],
            "MarchTest" => ["expectedDateStart" => "2022-03-01 00:00:00", "expectedDateEnd" => "2022-03-31 23:59:59", "month" => "03", "year" => "2022"],
            "AprilTest" => ["expectedDateStart" => "2022-04-01 00:00:00", "expectedDateEnd" => "2022-04-30 23:59:59", "month" => "04", "year" => "2022"],
            "MayTest" => ["expectedDateStart" => "2022-05-01 00:00:00", "expectedDateEnd" => "2022-05-31 23:59:59", "month" => "05", "year" => "2022"],
            "JuneTest" => ["expectedDateStart" => "2022-06-01 00:00:00", "expectedDateEnd" => "2022-06-30 23:59:59", "month" => "06", "year" => "2022"],
            "JulyTest" => ["expectedDateStart" => "2022-07-01 00:00:00", "expectedDateEnd" => "2022-07-31 23:59:59", "month" => "07", "year" => "2022"],
            "AugustTest" => ["expectedDateStart" => "2022-08-01 00:00:00", "expectedDateEnd" => "2022-08-31 23:59:59", "month" => "08", "year" => "2022"],
            "SeptemberTest" => ["expectedDateStart" => "2022-09-01 00:00:00", "expectedDateEnd" => "2022-09-30 23:59:59", "month" => "09", "year" => "2022"],
            "OctoberTest" => ["expectedDateStart" => "2022-10-01 00:00:00", "expectedDateEnd" => "2022-10-31 23:59:59", "month" => "10", "year" => "2022"],
            "NovemberTest" => ["expectedDateStart" => "2022-11-01 00:00:00", "expectedDateEnd" => "2022-11-30 23:59:59", "month" => "11", "year" => "2022"],
            "DecemberTest" => ["expectedDateStart" => "2022-12-01 00:00:00", "expectedDateEnd" => "2022-12-31 23:59:59", "month" => "12", "year" => "2022"],
        ];
    }

    public function testGetThisYearPeriod()
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisYear')->andReturn(2023);

        $date = $calendarMock->getThisYearPeriod();
        $this->assertEquals("2023-01-01 00:00:00", $date->getStartDate());
        $this->assertEquals("2023-12-31 23:59:59", $date->getEndDate());
    }

    public function testGetYearPeriod()
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();

        $date = $calendarMock->getYearPeriod(2022);
        $this->assertEquals("2022-01-01 00:00:00", $date->getStartDate());
        $this->assertEquals("2022-12-31 23:59:59", $date->getEndDate());
    }

    #[DataProvider("dataProviderTestGetLastMonthPeriod")]
    public function testGetLastMonthPeriod($expectedDateStart, $expectedDateEnd, $month, $year)
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisMonth')->andReturn($month);
        $calendarMock->shouldReceive('getThisYear')->andReturn($year);

        $date = $calendarMock->getLastMonthPeriod();

        $this->assertEquals($expectedDateStart, $date->getStartDate());
        $this->assertEquals($expectedDateEnd, $date->getEndDate());
    }

    public static function dataProviderTestGetLastMonthPeriod(): array
    {
        return [
            "JanuaryTest" => ["expectedDateStart" => "2021-12-01 00:00:00", "expectedDateEnd" => "2021-12-31 23:59:59", "month" => "01", "year" => "2022"],
            "FebruaryTest" => ["expectedDateStart" => "2022-01-01 00:00:00", "expectedDateEnd" => "2022-01-31 23:59:59", "month" => "02", "year" => "2022"],
            "MarchTest" => ["expectedDateStart" => "2022-02-01 00:00:00", "expectedDateEnd" => "2022-02-28 23:59:59", "month" => "03", "year" => "2022"],
            "AprilTest" => ["expectedDateStart" => "2022-03-01 00:00:00", "expectedDateEnd" => "2022-03-31 23:59:59", "month" => "04", "year" => "2022"],
            "MayTest" => ["expectedDateStart" => "2022-04-01 00:00:00", "expectedDateEnd" => "2022-04-30 23:59:59", "month" => "05", "year" => "2022"],
            "JuneTest" => ["expectedDateStart" => "2022-05-01 00:00:00", "expectedDateEnd" => "2022-05-31 23:59:59", "month" => "06", "year" => "2022"],
            "JulyTest" => ["expectedDateStart" => "2022-06-01 00:00:00", "expectedDateEnd" => "2022-06-30 23:59:59", "month" => "07", "year" => "2022"],
            "AugustTest" => ["expectedDateStart" => "2022-07-01 00:00:00", "expectedDateEnd" => "2022-07-31 23:59:59", "month" => "08", "year" => "2022"],
            "SeptemberTest" => ["expectedDateStart" => "2022-08-01 00:00:00", "expectedDateEnd" => "2022-08-31 23:59:59", "month" => "09", "year" => "2022"],
            "OctoberTest" => ["expectedDateStart" => "2022-09-01 00:00:00", "expectedDateEnd" => "2022-09-30 23:59:59", "month" => "10", "year" => "2022"],
            "NovemberTest" => ["expectedDateStart" => "2022-10-01 00:00:00", "expectedDateEnd" => "2022-10-31 23:59:59", "month" => "11", "year" => "2022"],
            "DecemberTest" => ["expectedDateStart" => "2022-11-01 00:00:00", "expectedDateEnd" => "2022-11-30 23:59:59", "month" => "12", "year" => "2022"],
        ];
    }

    #[DataProvider("dataProviderTestAddOneMonthInDate")]
    public function testAddOneMonthInDate(string $date, int $period, string $expected)
    {
        $date = CalendarTools::addMonthInDate($date, $period);
        $this->assertEquals($expected, $date);
    }

    public static function dataProviderTestAddOneMonthInDate(): array
    {
        return [
            'OneMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 1, 'expected' => '2022-02-01 00:00:00'],
            'TwoMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 2, 'expected' => '2022-03-01 00:00:00'],
            'ThreeMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 3, 'expected' => '2022-04-01 00:00:00'],
            'FourMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 4, 'expected' => '2022-05-01 00:00:00'],
            'FiveMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 5, 'expected' => '2022-06-01 00:00:00'],
            'SixMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 6, 'expected' => '2022-07-01 00:00:00'],
            'SevenMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 7, 'expected' => '2022-08-01 00:00:00'],
            'EightMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 8, 'expected' => '2022-09-01 00:00:00'],
            'NineMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 9, 'expected' => '2022-10-01 00:00:00'],
            'TenMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 10, 'expected' => '2022-11-01 00:00:00'],
            'ElevenMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 11, 'expected' => '2022-12-01 00:00:00'],
            'TwelveMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 12, 'expected' => '2023-01-01 00:00:00'],
        ];
    }

    #[DataProvider("dataProviderTestSubMonthInDate")]
    public function testSubMonthInDate(string $date, int $period, string $expected)
    {
        $date = CalendarTools::subMonthInDate($date, $period);
        $this->assertEquals($expected, $date);
    }

    public static function dataProviderTestSubMonthInDate(): array
    {
        return [
            'OneMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 1, 'expected' => '2021-12-01 00:00:00'],
            'TwoMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 2, 'expected' => '2021-11-01 00:00:00'],
            'ThreeMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 3, 'expected' => '2021-10-01 00:00:00'],
            'FourMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 4, 'expected' => '2021-09-01 00:00:00'],
            'FiveMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 5, 'expected' => '2021-08-01 00:00:00'],
            'SixMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 6, 'expected' => '2021-07-01 00:00:00'],
            'SevenMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 7, 'expected' => '2021-06-01 00:00:00'],
            'EightMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 8, 'expected' => '2021-05-01 00:00:00'],
            'NineMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 9, 'expected' => '2021-04-01 00:00:00'],
            'TenMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 10, 'expected' => '2021-03-01 00:00:00'],
            'ElevenMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 11, 'expected' => '2021-02-01 00:00:00'],
            'TwelveMonthAdd' => ['date' => '2022-01-01 00:00:00', 'period' => 12, 'expected' => '2021-01-01 00:00:00'],
        ];
    }

    #[DataProvider("dataProviderTestGetIntervalMonthPeriodByMonthAndYear")]
    public function testGetIntervalMonthPeriodByMonthAndYear(int $month, int $year, int $period, string $dateStartExpected, string $dateEndExpected)
    {
        $interval = CalendarTools::getIntervalMonthPeriodByMonthAndYear($month, $year, $period);
        $this->assertEquals($dateStartExpected, $interval->getStartDate());
        $this->assertEquals($dateEndExpected, $interval->getEndDate());
    }

    public static function dataProviderTestGetIntervalMonthPeriodByMonthAndYear(): array
    {
        return [
            'OneMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 1, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-02-01 00:00:00'],
            'TwoMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 2, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-03-01 00:00:00'],
            'ThreeMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 3, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-04-01 00:00:00'],
            'FourMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 4, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-05-01 00:00:00'],
            'FiveMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 5, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-06-01 00:00:00'],
            'SixMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 6, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-07-01 00:00:00'],
            'SevenMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 7, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-08-01 00:00:00'],
            'EightMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 8, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-09-01 00:00:00'],
            'NineMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 9, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-10-01 00:00:00'],
            'TenMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 10, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-11-01 00:00:00'],
            'ElevenMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 11, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2022-12-01 00:00:00'],
            'TwelveMonthPeriod' => ['month' => 1, 'year' => 2022, 'period' => 12, 'dateStartExpected' => '2022-01-01 00:00:00', 'dateEndExpected' => '2023-01-01 00:00:00'],
        ];
    }

    public function testGetMonthLabelWithYear()
    {
        $this->assertEquals('01/2022', CalendarTools::getMonthLabelWithYear('2022-01-01 00:00:00'));
    }

    public function testGetYearFromDate()
    {
        $this->assertEquals('2022', CalendarTools::getYearFromStringDate('2022-01-01 00:00:00'));
    }

    public function testGetMonthPeriodFromDate()
    {
        $period = CalendarTools::getMonthPeriodFromDate('2022-01-01 00:00:00');
        $this->assertEquals('2022-01-01 00:00:00', $period->getStartDate());
        $this->assertEquals('2022-01-31 23:59:59', $period->getEndDate());
    }

    public function testMountDatePeriodFromIsoDateRange()
    {
        $datePeriod = [
            'dateStart' => '2022-01-01T00:00:00.000Z',
            'dateEnd' => '2022-01-31T23:59:59.000Z'
        ];

        $period = CalendarTools::mountDatePeriodFromIsoDateRange($datePeriod);

        $this->assertInstanceOf(DatePeriodDTO::class, $period);
        $this->assertEquals('2022-01-01 00:00:00', $period->getStartDate());
        $this->assertEquals('2022-01-31 23:59:59', $period->getEndDate());
    }

    #[TestDox('Testando Sem as posições necessárias no array')]
    public function testMakeDateRangeByDefaultFilterParamsTestOne()
    {
        $datePeriod = new DatePeriodDTO('2018-01-01', '2018-01-31');

        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisMonthPeriod')->once()->andReturn($datePeriod);
        $calendarMock->shouldReceive('mountDatePeriodFromIsoDateRange')->never();
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $this->assertEquals($datePeriod, $calendarMock->makeDateRangeByDefaultFilterParams([]));
    }

    #[TestDox('Testando Sem as posições necessárias no array')]
    public function testMakeDateRangeByDefaultFilterParamsTestTwo()
    {
        $datePeriod = new DatePeriodDTO('2018-01-01', '2018-01-31');

        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('mountDatePeriodFromIsoDateRange')->once()->andReturn($datePeriod);
        $calendarMock->shouldReceive('getThisMonthPeriod')->never();
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $this->assertEquals($datePeriod, $calendarMock->makeDateRangeByDefaultFilterParams(['dateStart' => '', 'dateEnd' => '']));
    }
}