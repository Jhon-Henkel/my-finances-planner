<?php

namespace App\Services\User;

use App\DTO\Mail\MailMessageDTO;
use App\DTO\User\UserRegisterDTO;
use App\Enums\StatusEnum;
use App\Exceptions\NotImplementedException;
use App\Models\User;
use App\Models\User\Plan;
use App\Models\User\Tenant;
use App\Services\BasicService;
use App\Services\Database\DatabaseService;
use App\Services\Mail\MailService;
use App\Services\Queue\QueueMessagesService;
use App\Tools\Calendar\CalendarTools;

class UserRegisterService extends BasicService
{
    public function __construct(
        private readonly DatabaseService $dbService,
        private readonly QueueMessagesService $queueMessagesService,
        private readonly MailService $mailService
    ) {
    }

    protected function getRepository()
    {
        throw new NotImplementedException();
    }

    public function registerUserStepOne(UserRegisterDTO $userRegister): void
    {
        $tenant = $this->dbService->createDatabaseAndTenant($userRegister);
        $user = $this->createUser($userRegister, $tenant);
        $this->queueMessagesService->putMessageUserRegisterStepTwo($user->id);
    }

    protected function createUser(UserRegisterDTO $userRegister, Tenant $tenant): User
    {
        $plan = new Plan();
        $user = User::create([
            'name' => $userRegister->getName(),
            'email' => $userRegister->getEmail(),
            'tenant_id' => $tenant->id,
            'plan_id' => $plan->freePlan()->id,
            'password' => bcrypt($userRegister->getPassword()),
            'status' => StatusEnum::Inactive->value,
            'wrong_login_attempts' => 0,
            'verify_hash' => md5((string)CalendarTools::getDateNow()->getTimestamp()),
        ]);
        $user->save();
        return $user;
    }

    public function registerUserStepTwo(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->dbService->runMigrationsInUser($user);
        $this->sendEmailRegisterDone($user);
    }

    protected function sendEmailRegisterDone(User $user): void
    {
        $subject = 'Conta criada com sucesso!';
        $template = 'emails.activeAccount';
        $data = [
            'hash' => $user->verify_hash,
            'name' => $user->name,
        ];
        $message = new MailMessageDTO($user->email, $user->name, $subject, $template, $data);
        $this->mailService->sendEmail($message);

    }

    public function registerUserStepThree(string $hash): void
    {
        $user = User::where('verify_hash', $hash)->firstOrFail();
        $user->status = StatusEnum::Active->value;
        $user->verify_hash = null;
        $user->email_verified_at = CalendarTools::getThisMonthString();
        $user->save();
    }
}
