<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\StatusEnum;
use Tests\backend\Falcon9;

class StatusEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(0, StatusEnum::Inactive->value);
        $this->assertEquals(1, StatusEnum::Active->value);
    }
}
