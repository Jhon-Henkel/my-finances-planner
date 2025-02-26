<?php

namespace App\Services\PaymentMethod\Stripe;

use App\DTO\Subscription\SubscriptionAgreementDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Models\User;
use App\Services\PaymentMethod\IPaymentMethod;
use DateTime;
use Stripe\Checkout\Session;
use Stripe\StripeClient;

class StripeService implements IPaymentMethod
{
    private null|StripeClient $client = null;

    public function getActiveSubscriptionStatus(): string
    {
        return 'active';
    }

    public function getCanceledSubscriptionStatus(): string
    {
        return 'canceled';
    }

    protected function getClient(): StripeClient
    {
        if (! $this->client) {
            $this->client = new StripeClient(config('app.payment_method_client_secret'));
        }
        return $this->client;
    }

    public function createAgreement(User $user): SubscriptionAgreementDTO
    {
        if ($user->subscription_id && $this->isPaymentLinkId($user->subscription_id)) {
            $clientSubscription = $this->getClient()->paymentLinks->retrieve($user->subscription_id);
        } else {
            $clientSubscription = $this->getClient()->paymentLinks->create([
                'line_items' => [
                    ['price' => config('app.payment_method_plan_id'), 'quantity' => 1]
                ],
                'after_completion' => [
                    'redirect' => [
                        'url' => config('app.url') . '/v2/assinatura-sucesso',
                    ],
                    'type' => 'redirect'
                ],
            ]);
        }
        return new SubscriptionAgreementDTO($clientSubscription->toArray());
    }

    public function getSubscription(User $user): SubscriptionDTO
    {
        if ($this->isPaymentLinkId($user->subscription_id)) {
            $checkoutSession = $this->getClient()->checkout->sessions->all(['payment_link' => $user->subscription_id]);
            if (count($checkoutSession->data) > 0 && ! $this->isSessionExpired(reset($checkoutSession->data))) {
                $session = reset($checkoutSession->data);
                $user->subscription_id = $session['subscription'];
            } else {
                $user->subscription_id = null;
            }
            $user->save();
        }
        $user->refresh();
        if ($this->isPaymentLinkId($user->subscription_id)) {
            return new SubscriptionDTO([]);
        }
        $subscription = $this->getClient()->subscriptions->retrieve($user->subscription_id);
        return new SubscriptionDTO($subscription->toArray());
    }

    protected function isSessionExpired(Session $session): bool
    {
        $expirationTime = new DateTime('@' . $session->expires_at);
        return $expirationTime < new DateTime();
    }

    protected function isPaymentLinkId(null|string $subscriptionId): bool
    {
        if (is_null($subscriptionId)) {
            return false;
        }
        return str_starts_with($subscriptionId, 'plink_');
    }

    public function cancelSubscription(string $subscriptionId, string $reason): void
    {
        $this->getClient()->subscriptions->cancel($subscriptionId);
    }
}
