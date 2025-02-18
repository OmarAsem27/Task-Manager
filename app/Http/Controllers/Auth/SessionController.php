<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class SessionController extends Controller
{

    public function create()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function store()
    {
        $validatedAttributes = request()->validate([
            'email' => 'required|email',
            'password' => ['required']
        ]);

        if (!Auth::attempt($validatedAttributes)) {
            throw ValidationException::withMessages([
                'email' => "Invalid email or password"
            ]);
        }

        request()->session()->regenerate();

        return redirect()->route('home');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
