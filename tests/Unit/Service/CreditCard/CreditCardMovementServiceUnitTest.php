<?php

namespace Tests\Unit\Service\CreditCard;

use App\Repositories\CreditCard\CreditCardMovementRepository;
use App\Services\CreditCard\CreditCardMovementService;
use Mockery;
use Tests\Falcon9;

class CreditCardMovementServiceUnitTest extends Falcon9
{
    public function testGetRepository()
    {
        $accessLogRepositoryMock = Mockery::mock(CreditCardMovementRepository::class);
        $accessLogService = Mockery::mock(CreditCardMovementService::class, [$accessLogRepositoryMock])->makePartial();
        $accessLogService->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCardMovementRepository::class, $accessLogService->getRepository());
    }
}