<?php

namespace Tests\backend\Unit\DTO\Date;

use App\DTO\Date\DatePeriodDTO;
use Tests\backend\Falcon9;

class DatePeriodDtoUnitTest extends Falcon9
{
    public function testDatePeriodDto()
    {
        $item = new DatePeriodDTO('2021-01-01', '2021-01-31');

        $this->assertEquals('2021-01-01', $item->getStartDate());
        $this->assertEquals('2021-01-31', $item->getEndDate());
    }
}
