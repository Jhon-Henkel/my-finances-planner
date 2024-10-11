<?php

namespace App\Services\Auth;

use App\DTO\Log\AccessLogDTO;
use App\DTO\Mail\MailMessageDTO;
use App\Enums\Cache\CacheKeyEnum;
use App\Enums\ConfigEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Services\ConfigurationService;
use App\Services\Log\AccessLogService;
use App\Services\Mail\MailService;
use App\Services\UserService;
use App\Tools\Auth\JwtTools;
use App\Tools\Cache\MfpCacheManager;
use App\Tools\Calendar\CalendarTools;
use App\Tools\Request\RequestTools;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public const int INVALID_LOGIN_OR_PASSWORD_CODE = 1;
    public const int INACTIVE_USER_CODE = 2;
    public const int OK_CODE = 3;

    public function __construct(
        private readonly UserService $userService,
        private readonly MailService $mailService,
        private readonly AccessLogService $accessLogService,
        private readonly ConfigurationService $configService
    ) {
    }

    public function findUserForAuth(string $email): Model|User|null
    {
        $user = MfpCacheManager::getModel($email, CacheKeyEnum::User);
        if (!$user) {
            $user = $this->userService->findUserByEmail($email);
            MfpCacheManager::setModel($email, CacheKeyEnum::User, $user);
        }
        return $user;
    }

    public function validateLogin(?User $user, string $password): int
    {
        if (! $user) {
            return self::INVALID_LOGIN_OR_PASSWORD_CODE;
        }
        if ($user->status === StatusEnum::Inactive->value) {
            return self::INACTIVE_USER_CODE;
        }
        if ($user->wrong_login_attempts > config('app.max_wrong_login_attempts')) {
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
        if ($user->status == StatusEnum::Inactive->value) {
            return;
        }
        $user->verify_hash = md5(uniqid($user->email) . time());
        $user->status = StatusEnum::Inactive->value;
        $user->save();
    }

    protected function sendEmailInactiveUser(User $user): void
    {
        $email = $this->generateDataForEmailInactiveUser($user);
        $this->mailService->sendEmail($email);
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
        $config = $this->configService->findConfigByName(ConfigEnum::MustShowWelcomePage->value, $user);
        return [
            'token' => JwtTools::createJWT($user),
            'must_show_welcome_page' => $config->getValue() == StatusEnum::Active->value,
            'user' => [
                'name' => $user->name,
                'id' => $user->id,
                'plan' => $user->plan()->name,
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
