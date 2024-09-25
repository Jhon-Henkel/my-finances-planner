<?php

namespace Tests\backend\Stubs\PaymentMethod;

use App\DTO\Subscription\SubscriptionAgreementDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Models\User;
use App\Services\PaymentMethod\PayPal\PayPalService;

class PayPalServiceStub extends PayPalService
{
    public string $subscriptionId;

    public function __construct(string $subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    public function createAgreement(User $user): SubscriptionAgreementDTO
    {
        return new SubscriptionAgreementDTO([
            'id' => $this->subscriptionId,
            'status' => 'ACTIVE',
            'create_time' => '2021-09-01T00:00:00Z',
            'links' => [
                ['rel' => 'approve', 'href' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-60U79048BN7719609'],
            ]
        ]);
    }

    public function cancelSubscription(string $subscriptionId, string $reason): void
    {
    }

    public function getSubscription(User $user): SubscriptionDTO
    {
        return new SubscriptionDTO(['id' => $this->subscriptionId , 'status' => 'ACTIVE']);
    }
}
