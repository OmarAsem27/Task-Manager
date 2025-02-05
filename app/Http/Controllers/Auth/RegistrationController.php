<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class RegistrationController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => ['required', Password::min(6), 'confirmed']
        ]);
        $user = User::create($fields);
        $user->assignRole('user');  // laravel permission

        Auth::login($user);
        return redirect('/tasks');
    }
}
