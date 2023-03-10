<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $user = User::where('email', $data['login'])->first();
        if (Auth::check() || ($user && Hash::check($data['senha'], $user->password))) {
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