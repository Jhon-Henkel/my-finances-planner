<?php

namespace Tests\backend\Unit\Enums\Queue;

use App\Enums\Queue\QueueNameEnum;
use Tests\backend\Falcon9;

class QueueNameEnumUnitTest extends Falcon9
{
    public function testEnum()
    {
        $this->assertEquals('create_user', QueueNameEnum::CreateUser->value);
        $this->assertEquals('check_subscription', QueueNameEnum::CheckSubscription->value);
    }

    public function testGetQueuesList()
    {
        $this->assertEquals([
            QueueNameEnum::CreateUser,
            QueueNameEnum::CheckSubscription,
        ], QueueNameEnum::getQueuesList());
    }
}
