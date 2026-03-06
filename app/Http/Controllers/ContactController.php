<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Tour;
class ContactController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | SHOW CONTACT FORM
    |--------------------------------------------------------------------------
    | Hiển thị form liên hệ cho user
    | URL: /contact
    */

    public function create()
    {
        return view('contact.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE CONTACT
    |--------------------------------------------------------------------------
    | Lưu dữ liệu contact vào database
    */

    public function store(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([

            'name' => 'required|string|max:255',

            'phone_number' => 'nullable|string|max:20',

            'email' => 'nullable|email|max:255',

            'message' => 'required|string|max:5000',

        ]);


        /*
        |--------------------------------------------------------------------------
        | SAVE CONTACT
        |--------------------------------------------------------------------------
        */

        $contact = Contact::create([

            'name' => $data['name'],

            'phone_number' => $data['phone_number'] ?? null,

            'email' => $data['email'] ?? null,

            'message' => $data['message'],

            'status' => 'new'

        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('contact.thanks')
            ->with('success', 'Cảm ơn bạn! Chúng tôi đã nhận được yêu cầu.');
    }



    /*
    |--------------------------------------------------------------------------
    | THANK YOU PAGE
    |--------------------------------------------------------------------------
    */

    public function thanks()
{
    $tours = Tour::where('status','active')
                ->where('is_featured',1)
                ->take(3)
                ->get();

    return view('contact.thanks', compact('tours'));
}

}