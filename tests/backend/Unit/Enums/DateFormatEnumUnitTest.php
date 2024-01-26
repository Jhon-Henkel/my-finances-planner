<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\DateFormatEnum;
use Tests\backend\Falcon9;

class DateFormatEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals('datetime:Y-m-d H:i:s', DateFormatEnum::ModelDefaultDateFormat->value);
        $this->assertEquals('d/m/Y H:i:s', DateFormatEnum::DefaultBrDateFormat->value);
        $this->assertEquals('Y-m-d H:i:s', DateFormatEnum::DefaultDbDateFormat->value);
        $this->assertEquals('Y-m-d', DateFormatEnum::UsaDateFormatWithoutTime->value);
        $this->assertEquals('m', DateFormatEnum::OnlyMonth->value);
        $this->assertEquals('d', DateFormatEnum::OnlyDay->value);
        $this->assertEquals('Y', DateFormatEnum::OnlyCompleteYear->value);
    }
}