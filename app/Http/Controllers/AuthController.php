<?php

namespace App\Http\Controllers;

use App\Enums\RouteEnum;
use App\Enums\ViewEnum;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function home()
    {
        // todo essa view não vai ser a publica
        return view('publica');
    }

    public function renderLoginView(): View|App|Factory|AppFoundation
    {
        return view(ViewEnum::VIEW_LOGIN);
    }

    public function login(Request $request): Redirector|RedirectResponse
    {
        // todo validar quantidade de tentativas de login, bloquear após 10 tentativas erradas
        $data = $request->all();
        $user = $this->findUserForAuth($data['login']);
        if ($this->validateLogin($user, $data['password'])) {
            Auth::login($user);
            return redirect()->route(RouteEnum::WEB_DASHBOARD);
        }
        // todo enviar erro de senha inválida no front
        return redirect()->route(RouteEnum::WEB_LOGIN);
    }

    protected function findUserForAuth(string $email): null|User
    {
        // todo essa busca deveria vir do service
        return User::where('email', $email)->first();
    }

    protected function validateLogin(?User $user, string $password):  bool
    {
        return Auth::check() || ($user && Hash::check($password, $user->password));
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route(RouteEnum::WEB_LOGIN);
    }
}