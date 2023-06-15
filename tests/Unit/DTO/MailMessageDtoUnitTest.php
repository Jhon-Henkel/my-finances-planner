<?php

namespace Tests\Unit\DTO;

use App\DTO\MailMessageDTO;
use Tests\TestCase;

class MailMessageDtoUnitTest extends TestCase
{
    public function testMailMessageDto()
    {
        $mailMessageDto = new MailMessageDTO(
            'test@test.com',
            'Test',
            'Test subject',
            'emails.testMail',
            ['title'=>'This is a mail test', 'body' => 'A test send mail from app']
        );

        $this->assertEquals('test@test.com', $mailMessageDto->getAddressee());
        $this->assertEquals('Test', $mailMessageDto->getAddresseeName());
        $this->assertEquals(env('MAIL_FROM_ADDRESS'), $mailMessageDto->getSender());
        $this->assertEquals(str_replace('_', ' ', env('MAIL_FROM_NAME')), $mailMessageDto->getSenderName());
        $this->assertEquals('Test subject', $mailMessageDto->getSubject());
        $this->assertEquals('emails.testMail', $mailMessageDto->getTempleteFile());
        $this->assertEquals(['title'=>'This is a mail test', 'body' => 'A test send mail from app'], $mailMessageDto->getData());
    }
}