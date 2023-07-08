<?php

namespace Tests\Unit\Tools;

use App\Tools\NumberTools;
use Tests\Falcon9;

class NumberToolsUnitTest extends Falcon9
{
    public function testRoundFloatAmount()
    {
        $this->assertEquals(10.12, NumberTools::roundFloatAmount(10.123456));
        $this->assertEquals(10.13, NumberTools::roundFloatAmount(10.129999));
        $this->assertEquals(10, NumberTools::roundFloatAmount(10));
    }
}