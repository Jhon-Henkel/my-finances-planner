<?php

namespace App\Services\Mail;

use App\DTO\Mail\MailMessageDTO;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendTestEmail(): void
    {
        $this->sendEmail(new MailMessageDTO(
            config('app.mail_from_address'),
            'Account Test',
            'Test Send Email From App',
            'emails.testMail',
            ['title' => 'This is a mail test', 'body' => 'A test mail send from app']
        ));
    }

    /** @codeCoverageIgnore */
    public function sendEmail(MailMessageDTO $mail): void
    {
        if (config('app.env') === 'local') {
            dd("q");
            return;
        }
        dd('w');
        Mail::send($mail->getTempleteFile(), $mail->getParams(), function ($message) use ($mail) {
            $message->to($mail->getAddressee(), $mail->getAddresseeName());
            $message->subject($mail->getSubject());
            $message->from($mail->getSender(), $mail->getSenderName());
        });
    }

    /** @codeCoverageIgnore */
    public function isAppInDevMode(): bool
    {
        return RequestTools::isApplicationInDevelopMode();
    }
}
