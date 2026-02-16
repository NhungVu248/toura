<?php

namespace App\Http\Controllers\Auth;

use App\Models\Client\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Không thể đăng nhập bằng Google.');
        }

        // Tìm user theo email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Tạo user mới
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'GoogleUser',
                'email' => $googleUser->getEmail(),
                // nếu bạn có trường avatar, lưu $googleUser->getAvatar()
                'password' => bcrypt(Str::random(24)), // password random
                'email_verified_at' => now(), // đánh dấu đã verified
            ]);

            event(new Registered($user)); // không cần thiết vì đã set verified, nhưng ok để giữ consistency
        } else {
            // Nếu user tồn tại mà chưa verify, bạn có thể mark verified nếu email của Google đã xác thực
            if ($user->email_verified_at === null) {
                $user->email_verified_at = now();
                $user->save();
            }
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }
}
