<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function getLogin()
    {
        return view('dashboard.auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->guard('admin')->attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ])) {
            $user = auth()->guard('admin')->user();
            if ($user->activated == true) {
                return redirect()->route('dashboard.home');
            } else {
                return back()->with('error', 'Votre compte a été temporairement bloqué.');
            }
        }

        return back()->with('error', 'Votre idéntifiant ou mot de passe incorrect!');
    }

    public function Logout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();

        return redirect()->route('dashboard.login');
    }
}
