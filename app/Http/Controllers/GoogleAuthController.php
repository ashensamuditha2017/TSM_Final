<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(){
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'password' => null, // No password for social login
                ]);
                Auth::login($new_user);

                return redirect()->with('success', 'Registration successful! Welcome, ' . $new_user->name)->intended('home');
            }
            else{
                Auth::login($user);
                return redirect()->with('success', 'Login successful! Welcome back, ' . $user->name)->intended('home');
            }

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Failed to authenticate with Google.']);
        }
    }
}
