<?php

namespace Tests\backend\Unit\Tools\Auth;

use App\Models\User;
use App\Tools\Auth\JwtTools;
use Tests\backend\Falcon9;

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