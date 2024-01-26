<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\CalendarMonthsNumberEnum;
use Tests\backend\Falcon9;

class CalendarMonthsNumberEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(1, CalendarMonthsNumberEnum::January->value);
        $this->assertEquals(2, CalendarMonthsNumberEnum::February->value);
        $this->assertEquals(3, CalendarMonthsNumberEnum::March->value);
        $this->assertEquals(4, CalendarMonthsNumberEnum::April->value);
        $this->assertEquals(5, CalendarMonthsNumberEnum::May->value);
        $this->assertEquals(6, CalendarMonthsNumberEnum::June->value);
        $this->assertEquals(7, CalendarMonthsNumberEnum::July->value);
        $this->assertEquals(8, CalendarMonthsNumberEnum::August->value);
        $this->assertEquals(9, CalendarMonthsNumberEnum::September->value);
        $this->assertEquals(10, CalendarMonthsNumberEnum::October->value);
        $this->assertEquals(11, CalendarMonthsNumberEnum::November->value);
        $this->assertEquals(12, CalendarMonthsNumberEnum::December->value);
    }

    public function testGetMonthName()
    {
        $this->assertEquals('Janeiro', CalendarMonthsNumberEnum::getMonthName(1));
        $this->assertEquals('Fevereiro', CalendarMonthsNumberEnum::getMonthName(2));
        $this->assertEquals('Março', CalendarMonthsNumberEnum::getMonthName(3));
        $this->assertEquals('Abril', CalendarMonthsNumberEnum::getMonthName(4));
        $this->assertEquals('Maio', CalendarMonthsNumberEnum::getMonthName(5));
        $this->assertEquals('Junho', CalendarMonthsNumberEnum::getMonthName(6));
        $this->assertEquals('Julho', CalendarMonthsNumberEnum::getMonthName(7));
        $this->assertEquals('Agosto', CalendarMonthsNumberEnum::getMonthName(8));
        $this->assertEquals('Setembro', CalendarMonthsNumberEnum::getMonthName(9));
        $this->assertEquals('Outubro', CalendarMonthsNumberEnum::getMonthName(10));
        $this->assertEquals('Novembro', CalendarMonthsNumberEnum::getMonthName(11));
        $this->assertEquals('Dezembro', CalendarMonthsNumberEnum::getMonthName(12));
    }

    public function testLabel()
    {
        $this->assertEquals('Janeiro', CalendarMonthsNumberEnum::January->label());
        $this->assertEquals('Fevereiro', CalendarMonthsNumberEnum::February->label());
        $this->assertEquals('Março', CalendarMonthsNumberEnum::March->label());
        $this->assertEquals('Abril', CalendarMonthsNumberEnum::April->label());
        $this->assertEquals('Maio', CalendarMonthsNumberEnum::May->label());
        $this->assertEquals('Junho', CalendarMonthsNumberEnum::June->label());
        $this->assertEquals('Julho', CalendarMonthsNumberEnum::July->label());
        $this->assertEquals('Agosto', CalendarMonthsNumberEnum::August->label());
        $this->assertEquals('Setembro', CalendarMonthsNumberEnum::September->label());
        $this->assertEquals('Outubro', CalendarMonthsNumberEnum::October->label());
        $this->assertEquals('Novembro', CalendarMonthsNumberEnum::November->label());
        $this->assertEquals('Dezembro', CalendarMonthsNumberEnum::December->label());
    }
}
