<?php

namespace Tests\Unit\Tools;

use App\Tools\RequestTools;
use Tests\TestCase;

class RequestToolsUnitTest extends TestCase
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

        $this->assertEquals('def', RequestTools::imputPost('abc'));
        $this->assertEquals(null, RequestTools::imputPost('aaa'));
    }

    public function testImputPostAll()
    {
        $_POST['abc'] = 'def';
        $post = RequestTools::imputPostAll();

        $this->assertCount(1, $post);
        $this->assertArrayHasKey('abc', $post);
    }

    public function testImputGet()
    {
        $_GET['jkl'] = 'ert';

        $this->assertEquals('ert', RequestTools::imputGet('jkl'));
        $this->assertEquals(null, RequestTools::imputGet('aaa'));
    }
}