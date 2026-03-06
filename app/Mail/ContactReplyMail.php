<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    /*
    |--------------------------------------------------------------------------
    | DATA VARIABLES
    |--------------------------------------------------------------------------
    | chứa thông tin contact và nội dung reply
    */

    public $contact;
    public $adminReply;


    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    | nhận dữ liệu từ Controller
    */

    public function __construct($contact, $adminReply)
    {
        $this->contact = $contact;
        $this->adminReply = $adminReply;
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD MAIL
    |--------------------------------------------------------------------------
    | cấu hình email gửi đi
    */

    public function build()
    {
        return $this->subject('Phản hồi từ ' . config('app.name'))
                    ->markdown('emails.contact.reply')
                    ->with([
                        'contact' => $this->contact,
                        'adminReply' => $this->adminReply,
                    ]);
    }
}