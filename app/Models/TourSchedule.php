<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourSchedule extends Model
{
    use HasFactory;

    protected $table = 'tbl_tour_schedules';

    protected $fillable = [
        'tour_id',
        'departure_date',
        'departure_time',
        'seats_total',
        'seats_available',
        'price_override',
        'status'
    ];

    protected $casts = [
        'departure_date' => 'date',
        'departure_time' => 'datetime:H:i',
        'seats_total' => 'integer',
        'seats_available' => 'integer',
        'price_override' => 'decimal:2',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function isAvailable($quantity = 1)
    {
        return $this->status === 'open'
            && $this->seats_available >= $quantity;
    }

    public function reduceSeats($quantity)
    {
        if ($this->isAvailable($quantity)) {
            $this->decrement('seats_available', $quantity);

            if ($this->seats_available <= 0) {
                $this->update(['status' => 'sold_out']);
            }

            return true;
        }

        return false;
    }
}