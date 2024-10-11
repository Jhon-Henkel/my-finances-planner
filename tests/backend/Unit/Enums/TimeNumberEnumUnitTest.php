<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\TimeNumberEnum;
use Tests\backend\Falcon9;

class TimeNumberEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(7200, TimeNumberEnum::TwoHourInSeconds->value);
        $this->assertEquals(10800, TimeNumberEnum::ThreeHourInSeconds->value);
    }
}
