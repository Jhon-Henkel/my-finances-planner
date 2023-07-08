<?php

namespace Tests\Unit\DTO;

use App\DTO\DatePeriodDTO;
use Tests\Falcon9;

class DatePeriodDtoUnitTest extends Falcon9
{
    public function testDatePeriodDto()
    {
        $item = new DatePeriodDTO('2021-01-01', '2021-01-31');

        $this->assertEquals('2021-01-01', $item->getStartDate());
        $this->assertEquals('2021-01-31', $item->getEndDate());
    }
}