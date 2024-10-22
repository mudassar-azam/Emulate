<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Socialite;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $redirectRoute = ($user->role === 'seller' || $user->role === 'admin') ? route('seller.front') : route('buyer.front');

            return response()->json(['redirect' => $redirectRoute]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {

            Auth::login($existingUser);

        } else {

            $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make('12345678'),
                'role' => 'buyer',
            ]);

            Auth::login($newUser);
        }

        return redirect()->route('buyer.front'); 
    }
}
