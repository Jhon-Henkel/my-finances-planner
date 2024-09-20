<?php

namespace App\Services\Subscription;

use App\DTO\Mail\MailMessageDTO;
use App\Enums\PaymentMethod\PaymentMethodNameEnum;
use App\Exceptions\PaymentMethod\PaymentMethodNotFountException;
use App\Models\User;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Mail\MailService;
use App\Services\PaymentMethod\IPaymentMethod;
use App\Services\PaymentMethod\PayPal\PayPalService;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    private IPaymentMethod $paymentMethod;
    private null|DatabaseConnectionService $connection = null;

    public function __construct(private readonly MailService $mailService)
    {
        $this->paymentMethod = $this->getPaymentMethodInstance();
    }

    protected function getPaymentMethod(): IPaymentMethod
    {
        return $this->paymentMethod;
    }

    protected function getConnection(): DatabaseConnectionService
    {
        if (! $this->connection) {
            $this->connection = new DatabaseConnectionService();
            $this->connection->setMasterConnection();
        }
        return $this->connection;
    }

    protected function getPaymentMethodInstance(): IPaymentMethod
    {
        return match (config('app.payment_method_name')) {
            PaymentMethodNameEnum::PayPal->value => new PayPalService(),
            default => throw new PaymentMethodNotFountException(),
        };
    }

    public function createAgreement(): array
    {
        $user = Auth::user();
        $agreement = $this->getPaymentMethod()->createAgreement($user);
        $user->subscription_id = $agreement->getSubscriptionId();
        $user->save();
        $this->getConnection()->connectUser($user);
        return $agreement->toArray();
    }

    public function cancelAgreement(string $reason): void
    {
        $user = Auth::user();
        $this->getPaymentMethod()->cancelSubscription($user->subscription_id, $reason);
        $user->subscription_id = null;
        $this->getConnection()->connectUser($user);
        $user->save();
        $this->mailService->sendEmail($this->generateDataForCreateCancelSubscriptionEmail($user));
    }

    public function getSubscription(): array
    {
        $user = Auth::user();
        $subscription = $this->getPaymentMethod()->getSubscription($user->subscription_id);
        $this->getConnection()->connectUser($user);
        return $subscription->toArray();
    }

    protected function generateDataForCreateCancelSubscriptionEmail(User $user): MailMessageDTO
    {
        $subject = 'Cancelamento de assinatura';
        $template = 'emails.subscription.cancel';
        $data = ['name' => $user->name];
        return new MailMessageDTO($user->email, $user->name, $subject, $template, $data);
    }
}
