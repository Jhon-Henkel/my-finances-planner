<?php

namespace Tests\backend\Unit\DTO\Mail;

use App\DTO\Mail\MailMessageDTO;
use Tests\backend\Falcon9;

class MailMessageDtoUnitTest extends Falcon9
{
    public function testMailMessageDto()
    {
        $mailMessageDto = new MailMessageDTO(
            'test@test.com',
            'Test',
            'Test subject',
            'emails.testMail',
            ['title' => 'This is a mail test', 'body' => 'A test send mail from app']
        );

        $mailFrom = config('app.mail_from_address');
        $mailFromName = str_replace('_', ' ', config('app.mail_from_name'));
        $params = ['title' => 'This is a mail test', 'body' => 'A test send mail from app'];

        $this->assertEquals('test@test.com', $mailMessageDto->getAddressee());
        $this->assertEquals('Test', $mailMessageDto->getAddresseeName());
        $this->assertEquals($mailFrom, $mailMessageDto->getSender());
        $this->assertEquals($mailFromName, $mailMessageDto->getSenderName());
        $this->assertEquals('Test subject', $mailMessageDto->getSubject());
        $this->assertEquals('emails.testMail', $mailMessageDto->getTempleteFile());
        $this->assertEquals($params, $mailMessageDto->getParams());
    }
}
