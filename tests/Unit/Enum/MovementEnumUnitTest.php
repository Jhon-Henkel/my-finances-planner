<?php

use App\Enums\MovementEnum;
use Tests\Falcon9;

class MovementEnumUnitTest extends Falcon9
{
    public function testEnum()
    {
        $this->assertEquals(0, MovementEnum::ALL);
        $this->assertEquals(2, MovementEnum::FILTER_BY_THIS_MONTH);
        $this->assertEquals(3, MovementEnum::FILTER_BY_LAST_MONTH);
        $this->assertEquals(4, MovementEnum::FILTER_BY_THIS_YEAR);
        $this->assertEquals(5, MovementEnum::SPENT);
        $this->assertEquals(6, MovementEnum::GAIN);
        $this->assertEquals(7, MovementEnum::TRANSFER);
    }
}