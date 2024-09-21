<?php

namespace App\Enums\Queue;

enum QueueNameEnum: string
{
    case CreateUser = 'create_user';
    case CheckSubscription = 'check_subscription';

    public static function getQueuesList(): array
    {
        return [
            self::CreateUser,
            self::CheckSubscription,
        ];
    }
}
