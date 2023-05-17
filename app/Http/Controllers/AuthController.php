<?php

namespace App\Http\Controllers;

use App\Enums\BasicFieldsEnum;
use App\Enums\ConfigEnum;
use App\Enums\ViewEnum;
use App\Models\User;
use App\Services\ConfigurationService;
use App\Services\UserService;
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
    public function renderLoginView(): View|App|Factory|AppFoundation
    {
        return view(ViewEnum::VIEW_LOGIN);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->all();
        $user = $this->findUserForAuth($data['email']);
        if ($this->validateLogin($user, $data['password'])) {
            Auth::login($user);
            return response()->json('Logado com sucesso!', ResponseAlias::HTTP_OK);
        }
        return response()->json('Login ou senha inválidos!', ResponseAlias::HTTP_UNAUTHORIZED);
    }

    protected function findUserForAuth(string $email): null|User
    {
        $userService = app(UserService::class);
        return $userService->findUserByEmail($email);
    }

    protected function validateLogin(?User $user, string $password):  bool
    {
        if (! $user) {
            return false;
        }
        if ($user->status === ConfigEnum::STATUS_INACTIVE) {
            return false;
        }
        if ($user->wrong_login_attempts > ConfigEnum::MAX_WRONG_LOGIN_ATTEMPTS) {
            $this->inactiveUser($user);
            return false;
        }
        if (Hash::check($password, $user->password)) {
            if ($user->wrong_login_attempts > 0) {
                $user->wrong_login_attempts = 0;
                $user->save();
            }
            return true;
        }
        $this->incrementWrongLoginAttempts($user);
        return false;
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

    public function getMfpToken(): JsonResponse
    {
        $mfpToken = '';
        if (Auth::check()) {
            $mfpToken = app(ConfigurationService::class)->getMfpToken();
        }
        return response()->json([BasicFieldsEnum::MFP_TOKEN => $mfpToken], ResponseAlias::HTTP_OK);
    }
}