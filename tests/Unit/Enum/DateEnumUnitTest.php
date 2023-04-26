<?php

namespace Tests\Unit\Enum;

use App\Enums\DateEnum;
use PHPUnit\Framework\TestCase;

class DateEnumUnitTest extends TestCase
{
    public function testGetMonthNameByNumber()
    {
        $this->assertEquals('Janeiro', DateEnum::getMonthNameByNumber(1));
        $this->assertEquals('Fevereiro', DateEnum::getMonthNameByNumber(2));
        $this->assertEquals('Março', DateEnum::getMonthNameByNumber(3));
        $this->assertEquals('Abril', DateEnum::getMonthNameByNumber(4));
        $this->assertEquals('Maio', DateEnum::getMonthNameByNumber(5));
        $this->assertEquals('Junho', DateEnum::getMonthNameByNumber(6));
        $this->assertEquals('Julho', DateEnum::getMonthNameByNumber(7));
        $this->assertEquals('Agosto', DateEnum::getMonthNameByNumber(8));
        $this->assertEquals('Setembro', DateEnum::getMonthNameByNumber(9));
        $this->assertEquals('Outubro', DateEnum::getMonthNameByNumber(10));
        $this->assertEquals('Novembro', DateEnum::getMonthNameByNumber(11));
        $this->assertEquals('Dezembro', DateEnum::getMonthNameByNumber(12));
    }
}
