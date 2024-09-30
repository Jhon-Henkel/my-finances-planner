<?php

namespace App\Exceptions\Subscription;

use App\Exceptions\ResponseExceptions\NotFoundException;

class PaymentNotificationUserNotFound extends NotFoundException
{
    public function __construct(array $data)
    {
        parent::__construct("Usuário não encontrado para notificação de pagamento, " . json_encode($data));
    }
}
