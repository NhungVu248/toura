<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;
use Carbon\Carbon;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255'
        ]);

        $email = strtolower($request->email);

        $subscriber = NewsletterSubscription::firstOrCreate(
            ['email' => $email],
            [
                'confirmed' => true,
                'subscribed_at' => Carbon::now()
            ]
        );

        return back()->with('success','Đăng ký nhận khuyến mãi thành công!');
    }
}