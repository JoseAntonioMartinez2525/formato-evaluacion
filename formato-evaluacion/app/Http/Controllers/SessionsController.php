<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/welcome');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas, por favor intente de nuevo',
            'password' => 'Credenciales incorrectas, por favor intente de nuevo',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function welcome(Request $request)
    {
        $user = Auth::user();

        // Pass the user's email to the view
        return view('welcome', compact('user'));
    }

}
