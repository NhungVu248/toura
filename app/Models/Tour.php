<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tour extends Model
{
    protected $table = 'tbl_tours';

    protected $fillable = [
        'title',
        'slug',
        'destination',
        'departure_location',
        'duration',
        'short_description',
        'description',
        'price_adult',
        'price_child',
        'thumbnail',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price_adult' => 'decimal:2',
        'price_child' => 'decimal:2',
    ];

    // Optional: use slug for route model binding
    //public function getRouteKeyName()
    //{
     //   return 'slug';
    //}

    // Helper: create unique slug
    public static function makeUniqueSlug($title)
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;
        while (self::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}