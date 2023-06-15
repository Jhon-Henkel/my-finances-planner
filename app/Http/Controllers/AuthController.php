<?php

namespace App\Http\Controllers;

use App\DTO\MailMessageDTO;
use App\Enums\BasicFieldsEnum;
use App\Enums\ConfigEnum;
use App\Enums\ViewEnum;
use App\Exceptions\UserException;
use App\Http\Response\ResponseError;
use App\Models\User;
use App\Services\MailService;
use App\Services\UserService;
use App\Tools\ErrorReport;
use App\Tools\RequestTools;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    const INVALID_LOGIN_OR_PASSWORD_CODE = 1;
    const INACTIVE_USER_CODE = 2;
    const OK_CODE = 3;

    public function renderLoginView(): View|App|Factory|AppFoundation
    {
        return view(ViewEnum::VIEW_LOGIN);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->all();
        $user = $this->findUserForAuth($data['email']);
        $loginCode = $this->validateLogin($user, $data['password']);
        if ($loginCode === self::OK_CODE) {
            Auth::login($user);
            return response()->json('Logado com sucesso!', ResponseAlias::HTTP_OK);
        } elseif ($loginCode === self::INACTIVE_USER_CODE) {
            $message = 'Usuário inativo!';
            return ResponseError::responseError($message, ResponseAlias::HTTP_FORBIDDEN);
        } elseif ($loginCode === self::INVALID_LOGIN_OR_PASSWORD_CODE) {
            $message = 'Usuário ou senha incorreto!';
            return ResponseError::responseError($message, ResponseAlias::HTTP_UNAUTHORIZED);
        } else {
            $message = 'Erro inesperado ao realizar login!';
            ErrorReport::report(new UserException($message));
            return ResponseError::responseError($message, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function findUserForAuth(string $email): null|User
    {
        $userService = app(UserService::class);
        return $userService->findUserByEmail($email);
    }

    protected function validateLogin(?User $user, string $password):  int
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
        $data = $this->generateDataForEmailInactiveUser($user);
        app(MailService::class)->sendEmail($data);
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

    public function logout(): JsonResponse
    {
        Auth::logout();
        Cache::clear();
        return response()->json([BasicFieldsEnum::MESSAGE => 'Logout realizado com sucesso']);
    }

    public function isUserLogged(): JsonResponse
    {
        $IsLogged = false;
        if (Auth::check()) {
            $IsLogged = true;
        }
        return response()->json([BasicFieldsEnum::IS_LOGGED => $IsLogged], ResponseAlias::HTTP_OK);
    }
}