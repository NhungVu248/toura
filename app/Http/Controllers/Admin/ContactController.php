<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContactController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | LIST CONTACTS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        $query = Contact::query();


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('q')) {

            $query->where(function($q) use ($request) {

                $q->where('name', 'like', '%'.$request->q.'%')

                  ->orWhere('email', 'like', '%'.$request->q.'%')

                  ->orWhere('phone_number', 'like', '%'.$request->q.'%');

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }


        $contacts = $query
                    ->orderBy('created_at','desc')
                    ->paginate(15);


        return view('admin.contacts.index', compact('contacts'));

    }



    /*
    |--------------------------------------------------------------------------
    | SHOW CONTACT
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {

        $contact = Contact::findOrFail($id);

        return view('admin.contacts.show', compact('contact'));

    }



    /*
    |--------------------------------------------------------------------------
    | REPLY CONTACT
    |--------------------------------------------------------------------------
    */

    public function reply(Request $request, $id)
    {

        $contact = Contact::findOrFail($id);


        $data = $request->validate([

            'admin_reply' => 'required|string|max:5000',

            'status' => 'nullable|in:new,in_progress,replied,closed',

        ]);


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | UPDATE CONTACT
            |--------------------------------------------------------------------------
            */

            $contact->admin_reply = $data['admin_reply'];

            $contact->status = $data['status'] ?? 'replied';

            $contact->replied_at = Carbon::now();

            $contact->save();



            /*
            |--------------------------------------------------------------------------
            | SEND EMAIL
            |--------------------------------------------------------------------------
            */

            if ($contact->email) {

                Mail::to($contact->email)
                    ->send(new ContactReplyMail($contact, $contact->admin_reply));

            }


            DB::commit();


            return back()->with('success','Đã gửi phản hồi thành công.');

        }
        catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors('Có lỗi xảy ra.');

        }

    }



    /*
    |--------------------------------------------------------------------------
    | DELETE CONTACT
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {

        $contact = Contact::findOrFail($id);

        $contact->delete();

        return redirect()
                ->route('admin.contacts.index')
                ->with('success','Đã xóa contact.');

    }

}