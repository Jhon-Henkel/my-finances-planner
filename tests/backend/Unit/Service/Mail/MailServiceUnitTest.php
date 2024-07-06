<?php

namespace Tests\backend\Unit\Service\Mail;

use App\Services\Mail\MailService;
use Mockery;
use Tests\backend\Falcon9;

class MailServiceUnitTest extends Falcon9
{
    public function testSendTestEmail()
    {
        $service = Mockery::mock(MailService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('sendEmail')->once()->andReturn(true);

        $service->sendTestEmail();

        $this->assertTrue(true);
    }
}
