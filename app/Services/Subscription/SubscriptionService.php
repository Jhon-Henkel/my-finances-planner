<?php

namespace App\Services\Subscription;

use App\DTO\Mail\MailMessageDTO;
use App\Enums\PaymentMethod\PaymentMethodNameEnum;
use App\Exceptions\PaymentMethod\PaymentMethodNotFountException;
use App\Exceptions\ResponseExceptions\BadRequestException;
use App\Models\User;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Mail\MailService;
use App\Services\PaymentMethod\IPaymentMethod;
use App\Services\PaymentMethod\PayPal\PayPalService;
use App\Services\User\PlanService;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    private IPaymentMethod $paymentMethod;
    private null|DatabaseConnectionService $connection = null;

    public function __construct(private readonly MailService $mailService, private readonly PlanService $planService)
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
        $this->sendCancelAgreementEmail($user);
    }

    protected function sendCancelAgreementEmail(User $user): void
    {
        $this->mailService->sendEmail($this->generateDataForCreateCancelSubscriptionEmail($user));
    }

    protected function generateDataForCreateCancelSubscriptionEmail(User $user): MailMessageDTO
    {
        $subject = 'Cancelamento de assinatura';
        $template = 'emails.subscription.cancel';
        $data = ['name' => $user->name];
        return new MailMessageDTO($user->email, $user->name, $subject, $template, $data);
    }

    public function updateAccount(string $email): void
    {
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            throw new BadRequestException('Usuário não encontrado para o e-mail informado');
        }
        if (is_null($user->subscription_id)) {
            return;
        }
        $subscription = $this->getPaymentMethod()->getSubscription($user->subscription_id);
        $data = $subscription->toArray();
        if ($this->mustUpdatePlanToPro($user, $data['status'])) {
            $user->plan_id = $this->planService->proPlan()->id;
            $user->save();
        } elseif ($this->mustUpdatePlanToFree($user, $data['status'])) {
            $user->plan_id = $this->planService->freePlan()->id;
            $user->subscription_id = null;
            $user->save();
        }
        $this->getConnection()->connectUser($user);
    }

    protected function mustUpdatePlanToFree(User $user, string $status): bool
    {
        return (in_array($status, ['CANCELLED', 'SUSPENDED', 'EXPIRED']) && ! $user->mustValidatePlanLimit())
            || (is_null($user->subscription_id));
    }

    protected function mustUpdatePlanToPro(User $user, string $status): bool
    {
        return $status === 'ACTIVE' && $user->mustValidatePlanLimit();
    }
}
