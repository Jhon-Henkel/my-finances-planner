<?php

namespace Tests\backend\Unit\DTO\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use Tests\backend\Falcon9;

class SubscriptionDtoUnitTest extends Falcon9
{
    public function testDTO()
    {
        $dto = new SubscriptionDTO([
            'status' => 'active',
            'current_period_end' => 1630000000
        ]);

        $this->assertEquals('active', $dto->getStatus());
        $this->assertEquals('2021-08-26 17:46:40', $dto->getCurrentPeriodEnd()->format('Y-m-d H:i:s'));
    }
}
