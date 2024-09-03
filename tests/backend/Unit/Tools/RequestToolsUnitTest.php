<?php

namespace Tests\backend\Unit\Tools;

use App\Tools\Request\RequestTools;
use Tests\backend\Falcon9;

class RequestToolsUnitTest extends Falcon9
{
    protected function setUp(): void
    {
        parent::setUp();
        unset($_POST['abc']);
        unset($_GET['jkl']);
    }

    protected function tearDown(): void
    {
        unset($_POST['abc']);
        unset($_GET['jkl']);
        parent::tearDown();
    }

    public function testInputGet()
    {
        $_GET['jkl'] = 'ert';

        $this->assertEquals('ert', RequestTools::inputGet('jkl'));
        $this->assertEquals(null, RequestTools::inputGet('aaa'));
        $this->assertEquals(['jkl' => 'ert'], RequestTools::inputGet());
    }

    public function testGetUserIp()
    {
        $_SERVER['REMOTE_ADDR'] = '192.155.33.22';

        $this->assertEquals('192.155.33.22', RequestTools::getUserIp());
    }

    public function testGetUserAgent()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)';

        $this->assertEquals('Mozilla/5.0 (Windows NT 10.0; Win64; x64)', RequestTools::getUserAgent());
    }
}
