<?php

namespace App\Http\Controllers;

use App\Enums\BasicFieldsEnum;
use App\Enums\ConfigEnum;
use App\Enums\RouteEnum;
use App\Enums\ViewEnum;
use App\Models\User;
use App\Services\ConfigurationService;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
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
        // todo validar quantidade de tentativas de login, bloquear após 10 tentativas erradas
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
        // todo essa busca deveria vir do service
        return User::where('email', $email)->first();
    }

    protected function validateLogin(?User $user, string $password):  bool
    {
        return $user && Hash::check($password, $user->password);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();
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
            $mfpToken = app(ConfigurationService::class)->findConfigValue(ConfigEnum::MFP_TOKEN);
        }
        return response()->json([BasicFieldsEnum::MFP_TOKEN => $mfpToken], ResponseAlias::HTTP_OK);
    }
}