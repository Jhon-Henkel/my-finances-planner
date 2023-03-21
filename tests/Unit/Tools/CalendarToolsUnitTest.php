<?php

namespace Tests\Unit\Tools;

use App\Tools\CalendarTools;
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

    public function testGetNextTwelveMonths()
    {
        $nextMonths = CalendarTools::getNextTwelveMonths(05);

        $this->assertCount(12, $nextMonths);
        $this->assertEquals(5, $nextMonths[0]);
        $this->assertEquals(6, $nextMonths[1]);
        $this->assertEquals(7, $nextMonths[2]);
        $this->assertEquals(8, $nextMonths[3]);
        $this->assertEquals(9, $nextMonths[4]);
        $this->assertEquals(10, $nextMonths[5]);
        $this->assertEquals(11, $nextMonths[6]);
        $this->assertEquals(12, $nextMonths[7]);
        $this->assertEquals(1, $nextMonths[8]);
        $this->assertEquals(2, $nextMonths[9]);
        $this->assertEquals(3, $nextMonths[10]);
        $this->assertEquals(4, $nextMonths[11]);

        $nextMonths = CalendarTools::getNextTwelveMonths(01);

        $this->assertCount(12, $nextMonths);
        $this->assertEquals(1, $nextMonths[0]);
        $this->assertEquals(2, $nextMonths[1]);
        $this->assertEquals(3, $nextMonths[2]);
        $this->assertEquals(4, $nextMonths[3]);
        $this->assertEquals(5, $nextMonths[4]);
        $this->assertEquals(6, $nextMonths[5]);
        $this->assertEquals(7, $nextMonths[6]);
        $this->assertEquals(8, $nextMonths[7]);
        $this->assertEquals(9, $nextMonths[8]);
        $this->assertEquals(10, $nextMonths[9]);
        $this->assertEquals(11, $nextMonths[10]);
        $this->assertEquals(12, $nextMonths[11]);

        $nextMonths = CalendarTools::getNextTwelveMonths(10);

        $this->assertCount(12, $nextMonths);
        $this->assertEquals(10, $nextMonths[0]);
        $this->assertEquals(11, $nextMonths[1]);
        $this->assertEquals(12, $nextMonths[2]);
        $this->assertEquals(1, $nextMonths[3]);
        $this->assertEquals(2, $nextMonths[4]);
        $this->assertEquals(3, $nextMonths[5]);
        $this->assertEquals(4, $nextMonths[6]);
        $this->assertEquals(5, $nextMonths[7]);
        $this->assertEquals(6, $nextMonths[8]);
        $this->assertEquals(7, $nextMonths[9]);
        $this->assertEquals(8, $nextMonths[10]);
        $this->assertEquals(9, $nextMonths[11]);
    }
}