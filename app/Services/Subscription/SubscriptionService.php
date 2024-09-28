<?php

namespace App\Services\Subscription;

use App\DTO\Mail\MailMessageDTO;
use App\Enums\PaymentMethod\PaymentMethodNameEnum;
use App\Exceptions\NotImplementedException;
use App\Exceptions\PaymentMethod\PaymentMethodNotFountException;
use App\Exceptions\ResponseExceptions\BadRequestException;
use App\Models\User;
use App\Services\BasicService;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Mail\MailService;
use App\Services\PaymentMethod\IPaymentMethod;
use App\Services\PaymentMethod\Stripe\StripeService;
use App\Services\User\PlanService;
use Illuminate\Support\Facades\Auth;

class SubscriptionService extends BasicService
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
            PaymentMethodNameEnum::Stripe->value => new StripeService(),
            default => throw new PaymentMethodNotFountException(),
        };
    }

    public function createAgreement(): array
    {
        $user = Auth::user();
        $agreement = $this->getPaymentMethod()->createAgreement($user);
        $user->subscription_id = $agreement->getSubscriptionId();
        $user->save();
        $this->sendPaymentLinkSubscriptionEmail($user, $agreement->getApproveLink());
        $this->getConnection()->connectUser($user);
        return $agreement->toArray();
    }

    protected function sendPaymentLinkSubscriptionEmail(User $user, string $paymentLink): void
    {
        $subject = 'Link de Pagamento';
        $template = 'emails.subscription.payment-link';
        $data = ['name' => $user->name, 'paymentLink' => $paymentLink];
        $this->mailService->sendEmail(new MailMessageDTO($user->email, $user->name, $subject, $template, $data));
    }

    public function cancelAgreement(string $reason): void
    {
        $user = Auth::user();
        $this->getPaymentMethod()->cancelSubscription($user->subscription_id, $reason);
        $user->subscription_id = null;
        $user->plan_id = $this->planService->freePlan()->id;
        $user->save();
        $this->getConnection()->connectUser($user);
        $this->sendCancelAgreementEmail($user);
    }

    protected function sendCancelAgreementEmail(User $user): void
    {
        $subject = 'Cancelamento de assinatura';
        $template = 'emails.subscription.cancel';
        $data = ['name' => $user->name];
        $this->mailService->sendEmail(new MailMessageDTO($user->email, $user->name, $subject, $template, $data));
    }

    public function updateAccount(string $email): void
    {
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            throw new BadRequestException('Usuário não encontrado para o e-mail informado');
        }
        if (! is_null($user->subscription_id)) {
            $subscription = $this->getPaymentMethod()->getSubscription($user);
            if ($this->mustUpdatePlanToPro($user, $subscription->getStatus())) {
                $user->plan_id = $this->planService->proPlan()->id;
            } elseif ($subscription->getStatus() !== $this->getPaymentMethod()->getActiveSubscriptionStatus()) {
                $user->plan_id = $this->planService->freePlan()->id;
                $user->subscription_id = null;
            }
        } else {
            $user->plan_id = $this->planService->freePlan()->id;
            $user->subscription_id = null;
        }
        $user->save();
        $this->getConnection()->connectUser($user);
    }

    public function paymentCompletedNotification(array $data): void
    {
        if (config('app.payment_method_name') === PaymentMethodNameEnum::Stripe->value) {
            $user = User::where('subscription_id', $data['data']['object']['payment_link'])->first();
            if (is_null($user)) {
                return;
            }
            $this->updateAccount($user->email);
            $this->sendWelcomeSubscriptionEmail($user);
        }
    }

    protected function sendWelcomeSubscriptionEmail(User $user): void
    {
        $subject = 'Bem Vindo(a)';
        $template = 'emails.subscription.welcome';
        $data = ['name' => $user->name];
        $this->mailService->sendEmail(new MailMessageDTO($user->email, $user->name, $subject, $template, $data));
    }

    protected function mustUpdatePlanToPro(User $user, string $status): bool
    {
        return $status === $this->getPaymentMethod()->getActiveSubscriptionStatus() && $user->mustValidatePlanLimit();
    }

    protected function getRepository()
    {
        throw new NotImplementedException();
    }
}
