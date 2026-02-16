<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    /**
     * Activate account by token
     */
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return view('auth.activation-result')->with('status', 'invalid');
        }

        // Check token expiry (60 minutes)
        if (!$user->activationTokenValid(60)) {
            return view('auth.activation-result')->with('status', 'expired');
        }

        // Activate account
        $user->email_verified_at = now();
        $user->activation_token = null;
        $user->activation_token_created_at = null;
        $user->save();

        // Login user
        Auth::login($user);

        return view('auth.activation-result')->with('status', 'success');
    }

    /**
     * Resend activation email
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản với email này.']);
        }

        if ($user->email_verified_at) {
            return back()->with('status', 'already_verified');
        }

        // Generate new token
        $token = hash_hmac('sha256', \Illuminate\Support\Str::random(40), config('app.key'));
        $user->activation_token = $token;
        $user->activation_token_created_at = now();
        $user->save();

        $user->notify(new \App\Notifications\VerifyAccountNotification($token));

        return back()->with('status', 'resent');
    }
}
