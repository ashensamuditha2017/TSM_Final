<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        // Define the scopes for Calendar, Gmail (read-only), and Tasks.
        $scopes = [
            'email',
            'profile',
            'https://www.googleapis.com/auth/calendar.readonly',
            'https://www.googleapis.com/auth/gmail.readonly',
            'https://www.googleapis.com/auth/tasks.readonly',
        ];

        return Socialite::driver('google')->scopes($scopes)->with(['access_type' => 'offline', 'prompt' => 'consent'])->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callbackGoogle()
    {
        try {
            // Get the user from Google Socialite
            $google_user = Socialite::driver('google')->user();

            // First, try to find a user by their Google ID
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                // If a user with that Google ID doesn't exist, check by email
                $user = User::where('email', $google_user->getEmail())->first();

                if ($user) {
                    // If a user with this email exists, update their record to link the Google ID and save the tokens
                    $user->google_id = $google_user->getId();
                    $user->google_access_token = $google_user->token;
                    $user->google_refresh_token = $google_user->refreshToken;
                    $user->save();
                } else {
                    // If no user exists with either the Google ID or email, create a new one
                    $user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'google_id' => $google_user->getId(),
                        'google_access_token' => $google_user->token,
                        'google_refresh_token' => $google_user->refreshToken,
                        'password' => null, // Social logins don't require a password
                    ]);
                }
            } else {
                // If the user exists, update their tokens
                $user->google_access_token = $google_user->token;
                // The refresh token is often only provided on the first authorization.
                // Only update it if a new one is available.
                $user->google_refresh_token = $google_user->refreshToken ?? $user->google_refresh_token;
                $user->save();
            }

            // Log in the user, whether they were just created or already existed
            Auth::login($user);

            // Redirect the user to the home page with a success message
            return redirect()->route('home')->with('success', 'Login successful! Welcome, ' . $user->name);

        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('Google authentication failed: ' . $e->getMessage());

            // Redirect to the login page with an error message
            return redirect()->route('login')->withErrors(['error' => 'Failed to authenticate with Google.']);
        }
    }

    public function logout(Request $request)
    {
        // Logout the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session's CSRF token
        $request->session()->regenerateToken();

        // Redirect to the welcome page
        return redirect('/');
    }
}