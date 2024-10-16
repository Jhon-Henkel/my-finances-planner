<?php

namespace App\Services\Subscription;

use App\DTO\Mail\MailMessageDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Enums\Cache\CacheKeyEnum;
use App\Enums\PaymentMethod\PaymentMethodNameEnum;
use App\Exceptions\NotImplementedException;
use App\Exceptions\PaymentMethod\PaymentMethodNotFountException;
use App\Exceptions\ResponseExceptions\BadRequestException;
use App\Exceptions\Subscription\PaymentNotificationUserNotFound;
use App\Models\User;
use App\Services\BasicService;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Mail\MailService;
use App\Services\PaymentMethod\IPaymentMethod;
use App\Services\PaymentMethod\Stripe\StripeService;
use App\Services\User\PlanService;
use App\Tools\Cache\MfpCacheManager;
use App\Tools\Calendar\CalendarTools;
use App\Tools\ErrorReport;
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
        /** @var null|User $user */
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            throw new BadRequestException('Usuário não encontrado para o e-mail informado');
        }
        if (is_null($user->subscription_id)) {
            return;
        }
        $subscription = $this->getPaymentMethod()->getSubscription($user);
        $user->refresh();
        if ($this->isActiveSubscription($subscription)) {
            if ($user->isFreePlan()) {
                $user->plan_id = $this->planService->proPlan()->id;
                $user->save();
            }
        } elseif ($this->isCanceledSubscription($subscription)) {
            if ($subscription->getCurrentPeriodEnd() >= CalendarTools::getDateNow()) {
                if ($user->isFreePlan()) {
                    $user->plan_id = $this->planService->proPlan()->id;
                }
            } elseif ($subscription->getCurrentPeriodEnd() < CalendarTools::getDateNow()) {
                if ($user->isProPlan()) {
                    $user->plan_id = $this->planService->freePlan()->id;
                    $user->subscription_id = null;
                }
            }
            $user->save();
        }
        MfpCacheManager::delete($user->email, CacheKeyEnum::User);
    }

    protected function isActiveSubscription(SubscriptionDTO $subscription): bool
    {
        return $subscription->getStatus() == $this->getPaymentMethod()->getActiveSubscriptionStatus();
    }

    protected function isCanceledSubscription(SubscriptionDTO $subscription): bool
    {
        return $subscription->getStatus() == $this->getPaymentMethod()->getCanceledSubscriptionStatus();
    }

    public function paymentCompletedNotification(array $data): void
    {
        if (config('app.payment_method_name') === PaymentMethodNameEnum::Stripe->value) {
            $user = User::where('subscription_id', $data['data']['object']['payment_link'])->first();
            if (is_null($user)) {
                ErrorReport::report(new PaymentNotificationUserNotFound($data));
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

    protected function getRepository()
    {
        throw new NotImplementedException();
    }
}
