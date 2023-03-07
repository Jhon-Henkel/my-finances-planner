<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Http\Redirector;
use Laravel\Lumen\Routing\Controller;

class AuthController extends Controller
{
    public function home()
    {
        return view('publica');
    }

    public function privada()
    {
        return view('privada');
    }

    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request): Redirector|RedirectResponse
    {
        $data = $request->all();
        $user = UserModel::where('email', $data['login'])->first();
        if (UserModel::isUserLogged() || ($user && Hash::check($data['senha'], $user->password))) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}