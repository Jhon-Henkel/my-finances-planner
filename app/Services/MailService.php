<?php

namespace App\Services;

use App\DTO\MailMessageDTO;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendTestEmail(): void
    {
        $this->sendEmail(new MailMessageDTO(
            env('VITE_EMAIL_CONTACT'),
            'Account Test',
            'Test Send Email From App',
            'emails.testMail',
            ['title'=>'This is a mail test', 'body' => 'A test mail sended from app']
        ));
    }

    /**
     * @codeCoverageIgnore
     */
    protected function sendEmail(MailMessageDTO $mail): void
    {
        Mail::send($mail->getTempleteFile(), $mail->getData(), function($message) use ($mail) {
            $message->to($mail->getAddressee(), $mail->getAddresseeName());
            $message->subject($mail->getSubject());
            $message->from($mail->getSender(), $mail->getSenderName());
        });
    }
}