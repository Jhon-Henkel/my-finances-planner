<?php

namespace App\Modules\MailNotification\UseCase\Master;

use App\DTO\Mail\MailMessageDTO;
use App\Models\User;
use App\Services\Mail\MailService;

readonly class NotifyCancelProUser
{
    public function __construct(private MailService $mailService)
    {
    }

    public function execute(User $user): void
    {
        $subject = 'Assinante nos deixando!';
        $template = 'emails.subscription.cancelSubscriptionUser';
        $data = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        $message = new MailMessageDTO(config('app.mail_master_address'), 'Master', $subject, $template, $data);
        $this->mailService->sendEmail($message);
    }
}
