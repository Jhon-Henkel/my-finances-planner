<?php

namespace Tests\Unit\Resource\Service\Mail;

use Tests\Falcon9;

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