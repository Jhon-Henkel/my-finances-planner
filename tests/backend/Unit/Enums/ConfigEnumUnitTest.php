<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\ConfigEnum;
use Tests\backend\Falcon9;

class ConfigEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals('mfp-token', ConfigEnum::MfpTokenKey->value);
        $this->assertEquals('x-mfp-user-token', ConfigEnum::MfpUserTokenKey->value);
        $this->assertEquals('HTTP_X_MFP_USER_TOKEN', ConfigEnum::XMfpUserTokenKey->value);
    }
}