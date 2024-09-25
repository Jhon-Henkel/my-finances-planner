<?php

namespace App\Services\PaymentMethod\Stripe;

use App\DTO\Subscription\SubscriptionAgreementDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Exceptions\PaymentMethod\PaymentMethodGetSubscriptionException;
use App\Models\User;
use App\Services\PaymentMethod\IPaymentMethod;
use Stripe\StripeClient;

class StripeService implements IPaymentMethod
{
    private null|StripeClient $client = null;

    public function getActiveSubscriptionStatus(): string
    {
        return 'active';
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
                    'hosted_confirmation' => [
                        'custom_message' => 'Obrigado por assinar nosso plano! Agora basta deslogar e logar novamente
                        para começar a usar.',
                    ],
                    'type' => 'hosted_confirmation'
                ],
            ]);
        }
        return new SubscriptionAgreementDTO($clientSubscription->toArray());
    }

    // todo - Criar webhook para checkout.session.completed
    public function getSubscription(User $user): SubscriptionDTO
    {
        if ($user->subscription_id && $this->isPaymentLinkId($user->subscription_id)) {
            $checkoutSession = $this->getClient()->checkout->sessions->all(['payment_link' => $user->subscription_id]);
            if (count($checkoutSession->data) > 0) {
                // todo - mandar e-mail de boas vindas no caso de uma nova assinatura
                $session = reset($checkoutSession->data);
                $user->subscription_id = $session['subscription'];
                $user->save();
            }
        }
        $subscription = $this->getClient()->subscriptions->retrieve($user->subscription_id);
        if (! $subscription) {
            throw new PaymentMethodGetSubscriptionException($user->subscription_id);
        }
        return new SubscriptionDTO($subscription->toArray());
    }

    protected function isPaymentLinkId(string $subscriptionId): bool
    {
        return str_starts_with($subscriptionId, 'plink_');
    }

    public function cancelSubscription(string $subscriptionId, string $reason): void
    {
        $this->getClient()->subscriptions->cancel($subscriptionId);
    }
}
