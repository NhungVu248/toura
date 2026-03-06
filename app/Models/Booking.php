<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'tour_id',
        'user_id',

        // contact
        'full_name',
        'email',
        'phone',
        'guest_quantity',

        'departure_date',
        'adult_quantity',
        'child_quantity',
        // services
        'travel_insurance',
        'private_guide',
        'airport_pickup',

        // discount
        'coupon_code',
        'discount_percent',
        'discount_amount',

        // price
        'tour_price',
        'subtotal',
        'service_total',
        'total_price',

        // status
        'payment_status',
        'booking_status'
    ];

    /*
    |--------------------------------------------------------------------------
    | TYPE CASTING
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'departure_date' => 'date',

        'travel_insurance' => 'boolean',
        'private_guide' => 'boolean',
        'airport_pickup' => 'boolean',

        'tour_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'service_total' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\Client\User::class, 'user_id');
    }

    public function services()
    {
        return $this->hasMany(BookingService::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (Auto Format)
    |--------------------------------------------------------------------------
    */

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_price, 0, ',', '.') . ' đ';
    }

    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal, 0, ',', '.') . ' đ';
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS LOGIC
    |--------------------------------------------------------------------------
    */

    public function calculateTotal()
    {
        $subtotal = $this->tour_price * $this->guest_quantity;

        $serviceTotal = 0;

        if ($this->travel_insurance) {
            $serviceTotal += 100000 * $this->guest_quantity;
        }

        if ($this->private_guide) {
            $serviceTotal += 500000 * $this->guest_quantity;
        }

        if ($this->airport_pickup) {
            $serviceTotal += 300000 * $this->guest_quantity;
        }

        $discount = $this->discount_amount ?? 0;

        $this->subtotal = $subtotal;
        $this->service_total = $serviceTotal;
        $this->total_price = $subtotal + $serviceTotal - $discount;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('booking_status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('booking_status', 'pending');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}