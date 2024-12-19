<?php

namespace App\Modules\MailNotification\UseCase\Master;

use App\DTO\Mail\MailMessageDTO;
use App\Models\User;
use App\Services\Mail\MailService;

readonly class NotifyNewProUser
{
    public function __construct(private MailService $mailService)
    {
    }

    public function execute(User $user): void
    {
        $subject = 'Novo assinante entrando!';
        $template = 'emails.subscription.newSubscriptionUser';
        $data = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        $message = new MailMessageDTO(config('app.mail_master_address'), 'Master', $subject, $template, $data);
        $this->mailService->sendEmail($message);
    }
}
