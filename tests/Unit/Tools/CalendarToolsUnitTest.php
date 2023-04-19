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

    public function testSalutationAftermoonWithName()
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
}