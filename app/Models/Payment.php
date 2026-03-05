<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'booking_id',
        'payment_method',
        'payment_provider',
        'amount',
        'discount_percent',
        'final_amount',
        'payment_status',
        'transaction_code',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'paid_at' => 'datetime'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Payment belongs to Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Payment -> Card
    public function card()
    {
        return $this->hasOne(PaymentCard::class);
    }

    // Payment -> Bank Transfer
    public function bankTransfer()
    {
        return $this->hasOne(BankTransfer::class);
    }

    // Payment -> Ewallet
    public function ewallet()
    {
        return $this->hasOne(EwalletPayment::class);
    }
    
}