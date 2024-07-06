<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\InvestmentEnum;
use Tests\backend\Falcon9;

class InvestmentEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(1, InvestmentEnum::Cdb->value);
        $this->assertEquals(2, InvestmentEnum::CdbCreditLimit->value);
    }

    public function testGetAllCdbIdTypes()
    {
        $this->assertEquals([1, 2], InvestmentEnum::getAllCdbIdTypes());
    }
}
