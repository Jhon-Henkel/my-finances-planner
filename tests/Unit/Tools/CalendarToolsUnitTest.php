<?php

namespace Tests\Unit\Tools;

use App\Tools\CalendarTools;
use Exception;
use Mockery;
use Tests\TestCase;

class CalendarToolsUnitTest extends TestCase
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
        $date = CalendarTools::usToBrDate('2022-12-01 15:10:50');

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

    public function testGetNextSixMonths()
    {
        $nextMonths = CalendarTools::getNextSixMonths(05);

        $this->assertCount(6, $nextMonths);
        $this->assertEquals('05', $nextMonths[0]);
        $this->assertEquals('06', $nextMonths[1]);
        $this->assertEquals('07', $nextMonths[2]);
        $this->assertEquals('08', $nextMonths[3]);
        $this->assertEquals('09', $nextMonths[4]);
        $this->assertEquals('10', $nextMonths[5]);

        $nextMonths = CalendarTools::getNextSixMonths(01);

        $this->assertCount(6, $nextMonths);
        $this->assertEquals('01', $nextMonths[0]);
        $this->assertEquals('02', $nextMonths[1]);
        $this->assertEquals('03', $nextMonths[2]);
        $this->assertEquals('04', $nextMonths[3]);
        $this->assertEquals('05', $nextMonths[4]);
        $this->assertEquals('06', $nextMonths[5]);

        $nextMonths = CalendarTools::getNextSixMonths(10);

        $this->assertCount(6, $nextMonths);
        $this->assertEquals('10', $nextMonths[0]);
        $this->assertEquals('11', $nextMonths[1]);
        $this->assertEquals('12', $nextMonths[2]);
        $this->assertEquals('01', $nextMonths[3]);
        $this->assertEquals('02', $nextMonths[4]);
        $this->assertEquals('03', $nextMonths[5]);
    }

    /**
     * @dataProvider dataProviderTestGetMonthFromDate
     * @param string $date
     * @param string $expected
     * @return void
     * @throws Exception
     */
    public function testGetMonthFromDate(string $date, string $expected)
    {
        $this->assertEquals($expected, CalendarTools::getMonthFromDate($date));
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

    /**
     * @dataProvider dataProviderTestGetDayFromData
     * @return void
     */
    public function testGetDayFromData(string $date, string $expected)
    {
        $this->assertEquals($expected, CalendarTools::getDayFromDate($date));
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

    /**
     * @dataProvider dataProviderTestGetNextInstallment
     * @param $expected
     * @param $date
     * @return void
     */
    public function testGetNextInstallment($expected, $date)
    {
        $this->assertEquals($expected, CalendarTools::getNextInstallment($date));
    }

    public static function dataProviderTestGetNextInstallment(): array
    {
        return [
            "ActualMonthJanuaryTest" => ["expected" => "2022-2", "date" => "2022-1"],
            "ActualMonthFebruaryTest" => ["expected" => "2022-3", "date" => "2022-2"],
            "ActualMonthMarchTest" => ["expected" => "2022-4", "date" => "2022-3"],
            "ActualMonthAprilTest" => ["expected" => "2022-5", "date" => "2022-4"],
            "ActualMonthMayTest" => ["expected" => "2022-6", "date" => "2022-5"],
            "ActualMonthJuneTest" => ["expected" => "2022-7", "date" => "2022-6"],
            "ActualMonthJulyTest" => ["expected" => "2022-8", "date" => "2022-7"],
            "ActualMonthAugustTest" => ["expected" => "2022-9", "date" => "2022-8"],
            "ActualMonthSeptemberTest" => ["expected" => "2022-10", "date" => "2022-9"],
            "ActualMonthOctoberTest" => ["expected" => "2022-11", "date" => "2022-10"],
            "ActualMonthNovemberTest" => ["expected" => "2022-12", "date" => "2022-11"],
            "ActualMonthDecemberTest" => ["expected" => "2023-1", "date" => "2022-12"],
        ];
    }

    /**
     * @dataProvider dataProviderTestGetThisMonthPeriod
     * @param $expectedDateStart
     * @param $expectedDateEnd
     * @param $month
     * @param $year
     * @return void
     */
    public function testGetThisMonthPeriod($expectedDateStart, $expectedDateEnd, $month, $year)
    {
        $date = CalendarTools::getThisMonthPeriod($month, $year);
        $this->assertEquals($expectedDateStart, $date['start']);
        $this->assertEquals($expectedDateEnd, $date['end']);
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
        $date = CalendarTools::getThisYearPeriod(2023);
        $this->assertEquals("2023-01-01 00:00:00", $date['start']);
        $this->assertEquals("2023-12-31 23:59:59", $date['end']);
    }

    /**
     * @dataProvider dataProviderTestGetLastMonthPeriod
     * @param $expectedDateStart
     * @param $expectedDateEnd
     * @param $month
     * @param $year
     * @return void
     */
    public function testGetLastMonthPeriod($expectedDateStart, $expectedDateEnd, $month, $year)
    {
        $date = CalendarTools::getLastMonthPeriod($month, $year);
        $this->assertEquals($expectedDateStart, $date['start']);
        $this->assertEquals($expectedDateEnd, $date['end']);
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

    /**
     * @dataProvider dataProviderTestMountDateToPayInvoice
     * @return void
     */
    public function testMountDateToPayInvoice($expected, $month, $now)
    {
        $date = CalendarTools::mountDateToPayInvoice($month, $now);
        $this->assertEquals($expected, $date);
    }

    public static function dataProviderTestMountDateToPayInvoice(): array
    {
        return [
            "ThisYearJanuaryTest" => ["expected" => "2022-1", "month" => "1", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearFebruaryTest" => ["expected" => "2022-2", "month" => "2", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearMarchTest" => ["expected" => "2022-3", "month" => "3", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearAprilTest" => ["expected" => "2022-4", "month" => "4", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearMayTest" => ["expected" => "2022-5", "month" => "5", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearJuneTest" => ["expected" => "2022-6", "month" => "6", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearJulyTest" => ["expected" => "2022-7", "month" => "7", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearAugustTest" => ["expected" => "2022-8", "month" => "8", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearSeptemberTest" => ["expected" => "2022-9", "month" => "9", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearOctoberTest" => ["expected" => "2022-10", "month" => "10", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearNovemberTest" => ["expected" => "2022-11", "month" => "11", "now" => new \DateTime("2022-01-01 00:00:00")],
            "ThisYearDecemberTest" => ["expected" => "2022-12", "month" => "12", "now" => new \DateTime("2022-01-01 00:00:00")],
            "NextYearTest" => ["expected" => "2023-1", "month" => "1", "now" => new \DateTime("2022-12-01 00:00:00")],
        ];
    }

    public function testAddOneMonthInDate()
    {
        $date = "2022-01-01 00:00:00";
        $date = CalendarTools::addOneMonthInDate($date);
        $this->assertEquals("2022-02-01 00:00:00", $date);
    }
}