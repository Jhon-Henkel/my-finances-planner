<?php

namespace Tests\Unit\Tools;

use App\Models\User;
use App\Tools\JwtTools;
use Tests\Falcon9;

class JwtToolsUnitTest extends Falcon9
{
    public function testJwt()
    {
        $user = new User();
        $jwt = JwtTools::createJWT($user);

        $this->assertIsString($jwt);
        $this->assertNotEmpty($jwt);

        $auth = JwtTools::validateJWT($jwt);

        $this->assertIsObject($auth);
        $this->assertNotEmpty($auth);
    }
}