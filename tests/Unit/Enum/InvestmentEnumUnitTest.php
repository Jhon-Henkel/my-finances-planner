<?php

namespace Enum;

use App\Enums\InvestmentEnum;
use Tests\Falcon9;

class InvestmentEnumUnitTest extends Falcon9
{
    public function testGetAllCdbIdTypes()
    {
        $expected = [
            InvestmentEnum::CDB_ID,
            InvestmentEnum::CDB_CREDIT_LIMIT_ID
        ];
        $this->assertEquals($expected, InvestmentEnum::getAllCdbIdTypes());
    }
}
