<?php

namespace Tests\Unit\Service;

use Tests\Falcon9;

class MailServiceUnitTest extends Falcon9
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