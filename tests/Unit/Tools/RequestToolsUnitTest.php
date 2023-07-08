<?php

namespace Tests\Unit\Tools;

use App\Tools\RequestTools;
use Tests\Falcon9;

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

    public function testImputPost()
    {
        $_POST['abc'] = 'def';

        $this->assertEquals('def', RequestTools::inputPost('abc'));
        $this->assertEquals(null, RequestTools::inputPost('aaa'));
    }

    public function testImputPostAll()
    {
        $_POST['abc'] = 'def';
        $post = RequestTools::inputPostAll();

        $this->assertCount(1, $post);
        $this->assertArrayHasKey('abc', $post);
    }

    public function testImputGet()
    {
        $_GET['jkl'] = 'ert';

        $this->assertEquals('ert', RequestTools::inputGet('jkl'));
        $this->assertEquals(null, RequestTools::inputGet('aaa'));
    }
}