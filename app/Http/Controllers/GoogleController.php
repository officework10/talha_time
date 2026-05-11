<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $userget = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $userget->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/');
            } else {
                // Check if the email already exists
                $existingUser = User::where('email', $userget->email)->first();
                if ($existingUser) {
                    // Handle the case where the email already exists
                    return redirect('login')->with('error', 'A user with this email already exists.');
                } else {
                    $current_timestamp = Carbon::now();  

                 
                    $newUser = User::create([
                        'name' => $userget->name,
                        'email' => $userget->email,
                        'google_id' => $userget->id,
                        'email_verified_at' => $current_timestamp,
                        'password' => '',
                    ]);
                    Auth::login($newUser);
                        return redirect('/');
                }
            }
        } catch (Exception $e) {
            // dd($e);
            return redirect()->route('login');
        }
    }
}
