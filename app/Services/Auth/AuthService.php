<?php

namespace App\Services\Auth;

use App\DTO\Log\AccessLogDTO;
use App\DTO\Mail\MailMessageDTO;
use App\Enums\ConfigEnum;
use App\Models\User;
use App\Services\Log\AccessLogService;
use App\Services\Mail\MailService;
use App\Services\UserService;
use App\Tools\Auth\JwtTools;
use App\Tools\CalendarTools;
use App\Tools\RequestTools;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    const INVALID_LOGIN_OR_PASSWORD_CODE = 1;
    const INACTIVE_USER_CODE = 2;
    const OK_CODE = 3;

    public function findUserForAuth(string $email): null|User
    {
        $userService = app(UserService::class);
        return $userService->findUserByEmail($email);
    }

    public function validateLogin(?User $user, string $password):  int
    {
        if (! $user) {
            return self::INVALID_LOGIN_OR_PASSWORD_CODE;
        }
        if ($user->status === ConfigEnum::STATUS_INACTIVE) {
            return self::INACTIVE_USER_CODE;
        }
        if ($user->wrong_login_attempts > ConfigEnum::MAX_WRONG_LOGIN_ATTEMPTS) {
            $this->inactiveUser($user);
            $this->sendEmailInactiveUser($user);
            return self::INACTIVE_USER_CODE;
        }
        if (Hash::check($password, $user->password)) {
            if ($user->wrong_login_attempts > 0) {
                $user->wrong_login_attempts = 0;
                $user->save();
            }
            return self::OK_CODE;
        }
        $this->incrementWrongLoginAttempts($user);
        return self::INVALID_LOGIN_OR_PASSWORD_CODE;
    }

    protected function inactiveUser(User $user): void
    {
        if (RequestTools::isApplicationInDemoMode()) {
            return;
        }
        if ($user->status == ConfigEnum::STATUS_INACTIVE) {
            return;
        }
        $user->verify_hash = md5(uniqid($user->email) . time());
        $user->status = ConfigEnum::STATUS_INACTIVE;
        $user->save();
    }

    protected function sendEmailInactiveUser(User $user): void
    {
        $email = $this->generateDataForEmailInactiveUser($user);
        app(MailService::class)->sendEmail($email);
    }

    protected function generateDataForEmailInactiveUser(User $user): MailMessageDTO
    {
        $subject = 'Ativação de usuário';
        $template = 'emails.activeUser';
        $data = [
            'linkToActiveUser' => route('activeUser', ['verifyHash' => $user->verify_hash]),
            'name' => $user->name,
        ];
        return new MailMessageDTO($user->email, $user->name, $subject, $template, $data);
    }

    protected function incrementWrongLoginAttempts(User $user): void
    {
        $user->wrong_login_attempts++;
        $user->save();
    }

    public function makeAuthUserResponseData(User $user): array
    {
        return [
            'token' => JwtTools::createJWT($user),
            'user' => [
                'name' => $user->name,
                'id' => $user->id,
                'salutation' => CalendarTools::salutation($user->name, date('H')),
                'salary' => $user->salary,
            ]
        ];
    }

    public function saveAccessLog(User $user, int $logged, string $comments): void
    {
        $log = new AccessLogDTO(
            null,
            $user->id,
            RequestTools::getUserIp(),
            $user->account_group,
            RequestTools::getUserAgent(),
            $logged,
            $comments,
        );
        $accessLogService = app(AccessLogService::class);
        $accessLogService->saveAccessLog($log);
    }
}