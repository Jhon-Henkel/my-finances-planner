<?php

namespace Tests\backend\Unit\Tools;

use App\Tools\NumberTools;
use Tests\backend\Falcon9;

class NumberToolsUnitTest extends Falcon9
{
    public function testRoundFloatAmount()
    {
        $this->assertEquals(10.12, NumberTools::roundFloatAmount(10.123456));
        $this->assertEquals(10.13, NumberTools::roundFloatAmount(10.129999));
        $this->assertEquals(10.13, NumberTools::roundFloatAmount("10.129999"));
        $this->assertEquals(10, NumberTools::roundFloatAmount(10));
        $this->assertEquals(10, NumberTools::roundFloatAmount("10"));
    }

    public function testMakeBalance()
    {
        $this->assertEquals(5.12, NumberTools::makeBalance(10.123456, 5));
        $this->assertEquals(-10.53, NumberTools::makeBalance(10.129999, 20.66));
        $this->assertEquals(10, NumberTools::makeBalance(10, 0));
    }
}
