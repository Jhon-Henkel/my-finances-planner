<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\MovementEnum;
use Tests\backend\Falcon9;

class MovementEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(0, MovementEnum::All->value);
        $this->assertEquals(2, MovementEnum::FilterByThisMonth->value);
        $this->assertEquals(3, MovementEnum::FilterByLastMonth->value);
        $this->assertEquals(4, MovementEnum::FilterByThisYear->value);
        $this->assertEquals(5, MovementEnum::Spent->value);
        $this->assertEquals(6, MovementEnum::Gain->value);
        $this->assertEquals(7, MovementEnum::Transfer->value);
        $this->assertEquals(8, MovementEnum::InvestmentCdb->value);
    }

    public function testGetTypesValidForFilter()
    {
        $this->assertEquals(
            [
                MovementEnum::Transfer->value,
                MovementEnum::Gain->value,
                MovementEnum::Spent->value,
                MovementEnum::InvestmentCdb->value,
            ],
            MovementEnum::getTypesValidForFilter()
        );
    }
}