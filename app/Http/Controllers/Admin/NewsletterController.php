<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscription::orderBy('created_at','desc')
                        ->paginate(20);

        return view('admin.newsletter.index', compact('subscribers'));
    }

    public function destroy($id)
    {
        $sub = NewsletterSubscription::findOrFail($id);
        $sub->delete();

        return back()->with('success','Đã xóa subscriber');
    }
}