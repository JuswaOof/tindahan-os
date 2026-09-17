<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function create(){
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request){

        $request->validate([
            'email' => ['required', 'email:rfc'],
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials are incorrect.',
        ]);

    }

    public function destroy(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}