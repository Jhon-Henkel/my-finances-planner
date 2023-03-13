<?php

namespace App\Http\Controllers;

use App\Enums\RouteEnum;
use App\Enums\ViewEnum;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function home()
    {
        return view('publica');
    }

    public function dashboard(): View|App|Factory|AppFoundation
    {
        return view(RouteEnum::WEB_DASHBOARD);
    }

    public function renderLoginView(): View|App|Factory|AppFoundation
    {
        return view(ViewEnum::VIEW_LOGIN);
    }

    public function login(Request $request): Redirector|RedirectResponse
    {
        $data = $request->all();
        // todo fazer esse find pelo service
        $user = User::where('email', $data['login'])->first();
        // todo transoformar "Auth::check() || ($user && Hash::check($data['password'], $user->password))" em metodo
        if (Auth::check() || ($user && Hash::check($data['password'], $user->password))) {
            Auth::login($user);
            return redirect()->route(RouteEnum::WEB_DASHBOARD);
        }
        return redirect()->route(RouteEnum::WEB_LOGIN);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route(RouteEnum::WEB_LOGIN);
    }
}