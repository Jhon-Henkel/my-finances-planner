<?php

namespace App\Services\Auth;

use App\DTO\Log\AccessLogDTO;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Request\RequestTools;
use App\Models\User;
use App\Services\Log\AccessLogService;
use App\Services\UserService;
use App\Tools\Auth\JwtTools;
use App\Tools\Calendar\CalendarTools;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public const int INVALID_LOGIN_OR_PASSWORD_CODE = 1;
    public const int INACTIVE_USER_CODE = 2;
    public const int OK_CODE = 3;

    public function __construct(
        private readonly UserService $userService,
        private readonly AccessLogService $accessLogService,
    ) {
    }

    public function findUserForAuth(string $email): User|null
    {
        return $this->userService->findUserByEmail($email);
    }

    public function validateLogin(?User $user, string $password): int
    {
        if (! $user) {
            return self::INVALID_LOGIN_OR_PASSWORD_CODE;
        }
        if ($user->status === StatusActiveInactiveEnum::Inactive->value) {
            return self::INACTIVE_USER_CODE;
        }
        if ($user->wrong_login_attempts > config('app.max_wrong_login_attempts')) {
            $this->inactiveUser($user);
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
        if ($user->status == StatusActiveInactiveEnum::Inactive->value) {
            return;
        }
        $user->verify_hash = md5(uniqid($user->email) . time());
        $user->status = StatusActiveInactiveEnum::Inactive->value;
        $user->save();
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
            'must_show_welcome_page' => false,
            'user' => [
                'name' => $user->name,
                'id' => $user->id,
                'salutation' => CalendarTools::salutation($user->name, (int)date('H')),
                'email' => $user->email,
            ]
        ];
    }

    public function saveAccessLog(User $user, int $logged, string $comments): void
    {
        $log = new AccessLogDTO(
            null,
            $user->id,
            RequestTools::getUserIp(),
            RequestTools::getUserAgent(),
            $logged,
            $comments,
        );
        $this->accessLogService->saveAccessLog($log);
    }
}
