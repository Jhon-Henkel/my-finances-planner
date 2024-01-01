<?php

namespace Tests\backend\Unit\Service\Mail;

use Tests\backend\Falcon9;

class MailServiceUnitTest extends Falcon9
{
    public function testSendTestEmail()
    {
        $service = \Mockery::mock('App\Services\Mail\MailService')->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('sendEmail')->once()->andReturn(true);

        $service->sendTestEmail();

        $this->assertTrue(true);
    }
}