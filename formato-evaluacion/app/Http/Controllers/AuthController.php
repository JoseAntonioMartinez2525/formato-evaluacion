<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validate and register the user
        //dd($request->all());
        $request->validate([
            'registerName' => 'required|string|max:255',
            'registerUsertype' => 'required|in:dictaminador,docente',
            'registerEmail' => 'required|string|email|max:255|unique:users,email',
            'registerPassword' => 'required|string|min:6|confirmed',
        ]);


        // Create the new user
        $user = new User();
        $user->name = $request->registerName;
        $user->user_type = $request->registerUsertype;
        $user->email = $request->registerEmail;
        $user->password = Hash::make($request->registerPassword);
        // Use Hash to encrypt the password
        $user->save();


        // Redirect or login the user
        return redirect()->route('login')->with('success', 'Registro exitoso. Por favor inicia sesión.');
    }
}
