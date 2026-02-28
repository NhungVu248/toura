<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = 'tbl_reviews';

    protected $fillable = [
        'tour_id',
        'user_id',
        'rating',
        'comment',
        'approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'approved' => 'boolean',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    protected static function booted()
    {
        static::created(function ($review) {
            if ($review->approved) {
                $review->tour->recalculateRating();
            }
        });

        static::updated(function ($review) {
            if ($review->isDirty('approved') && $review->approved) {
                $review->tour->recalculateRating();
            }
        });
    }
}