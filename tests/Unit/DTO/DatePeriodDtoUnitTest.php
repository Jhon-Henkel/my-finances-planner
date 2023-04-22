<?php

namespace Tests\Unit\DTO;

use App\DTO\DatePeriodDTO;
use Tests\TestCase;

class DatePeriodDtoUnitTest extends TestCase
{
    public function testDatePeriodDto()
    {
        $item = new DatePeriodDTO('2021-01-01', '2021-01-31');

        $this->assertEquals('2021-01-01', $item->getStartDate());
        $this->assertEquals('2021-01-31', $item->getEndDate());
    }
}