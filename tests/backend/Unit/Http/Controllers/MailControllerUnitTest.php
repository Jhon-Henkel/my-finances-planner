<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\Http\Controllers\MailController;
use App\Services\Mail\MailService;
use Mockery;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\backend\Falcon9;

class MailControllerUnitTest extends Falcon9
{
    #[TestDox('Testa o envio de e-mail de teste em modo desenvolvimento, deve permitir o envio')]
    public function testSendTestEmailTestOne()
    {
        $service = Mockery::mock(MailService::class)->makePartial();
        $service->shouldReceive('isAppInDevMode')->once()->andReturnTrue();
        $service->shouldReceive('sendTestEmail')->once()->andReturn();

        $controller = Mockery::mock(MailController::class, [$service])->makePartial();
        $controller->sendTestEmail();

        $this->assertTrue(true);
    }

    #[TestDox('Testa o envio de e-mail de teste em modo produção, não deve permitir o envio')]
    public function testSendTestEmailTestTwo()
    {
        $service = Mockery::mock(MailService::class)->makePartial();
        $service->shouldReceive('isAppInDevMode')->once()->andReturnFalse();
        $service->shouldReceive('sendTestEmail')->never();

        $controller = new MailController($service);
        $controller->sendTestEmail();

        $this->assertTrue(true);
    }
}
