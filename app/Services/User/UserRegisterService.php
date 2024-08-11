<?php

namespace App\Services\User;

use App\DTO\User\UserRegisterDTO;
use App\Enums\StatusEnum;
use App\Exceptions\NotImplementedException;
use App\Models\User;
use App\Models\User\Tenant;
use App\Services\BasicService;
use App\Services\Database\DatabaseService;
use App\Services\Queue\QueueMessagesService;
use App\Tools\Calendar\CalendarTools;

class UserRegisterService extends BasicService
{
    public function __construct(
        private readonly DatabaseService $dbService,
        private readonly QueueMessagesService $queueMessagesService
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
        $user = User::create([
            'name' => $userRegister->getName(),
            'email' => $userRegister->getEmail(),
            'tenant_id' => $tenant->id,
            'password' => bcrypt($userRegister->getPassword()),
            'status' => StatusEnum::Inactive->value,
            'wrong_login_attempts' => 0,
            'verify_hash' => md5(CalendarTools::getDateNow()->getTimestamp()),
        ]);
        $user->save();
        return $user;
    }
}
