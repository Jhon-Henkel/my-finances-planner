<?php

namespace Tests\Unit\Service;

use Tests\TestCase;

class MailServiceUnitTest extends TestCase
{
    public function testSendTestEmail()
    {
        $service = \Mockery::mock('App\Services\MailService')->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('sendEmail')->once()->andReturn(true);

        $service->sendTestEmail();

        $this->assertTrue(true);
    }
}