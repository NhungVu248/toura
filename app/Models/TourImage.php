<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourImage extends Model
{
    use HasFactory;

    protected $table = 'tbl_tour_images';

    protected $fillable = [
        'tour_id',
        'path',
        'caption',
        'is_primary',
        'sort_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}