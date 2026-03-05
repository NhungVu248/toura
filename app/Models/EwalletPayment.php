<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EwalletPayment extends Model
{
    protected $table = 'ewallet_payments';

    protected $fillable = [
        'payment_id',
        'wallet_provider',
        'transaction_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}