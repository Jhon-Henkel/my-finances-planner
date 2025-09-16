<?php

namespace Tests\backend\Unit\Enums;

use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\backend\Falcon9;

class MovementEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(0, MovementTypeEnum::All->value);
        $this->assertEquals(2, MovementTypeEnum::FilterByThisMonth->value);
        $this->assertEquals(3, MovementTypeEnum::FilterByLastMonth->value);
        $this->assertEquals(4, MovementTypeEnum::FilterByThisYear->value);
        $this->assertEquals(5, MovementTypeEnum::Spent->value);
        $this->assertEquals(6, MovementTypeEnum::Gain->value);
        $this->assertEquals(7, MovementTypeEnum::Transfer->value);
        $this->assertEquals(8, MovementTypeEnum::InvestmentCdb->value);
    }

    public function testGetTypesValidForFilter()
    {
        $this->assertEquals(
            [
                MovementTypeEnum::Transfer->value,
                MovementTypeEnum::Gain->value,
                MovementTypeEnum::Spent->value,
                MovementTypeEnum::InvestmentCdb->value,
            ],
            MovementTypeEnum::getTypesValidForFilter()
        );
    }
}
