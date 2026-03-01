<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tbl_tours';

    protected $fillable = [
        'title',
        'slug',
        'destination',
        'departure_location',
        'location_address',     // optional, nếu đã thêm
        'duration',
        'short_description',
        'description',
        'price_adult',
        'price_child',
        'price_original',       // optional, để hiển thị giá gốc
        'thumbnail',
        'status',
        'is_featured',
        'capacity',             // optional, số chỗ mặc định
        'cancellation_policy',  // optional
        'rating_avg',
        'rating_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price_adult' => 'decimal:2',
        'price_child' => 'decimal:2',
        'price_original' => 'decimal:2',
        'rating_avg' => 'decimal:2',
        'rating_count' => 'integer',
        'capacity' => 'integer',
    ];

    // Nếu bạn muốn binding route theo slug, bỏ comment hàm dưới
    //public function getRouteKeyName()
    //{
     //   return 'slug';
    //}

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        // Quan hệ 1:N với bảng tbl_tour_images
        return $this->hasMany(TourImage::class, 'tour_id')->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(TourImage::class, 'tour_id')->where('is_primary', true);
    }

    public function schedules()
    {
        return $this->hasMany(TourSchedule::class, 'tour_id')->orderBy('departure_date');
    }

    public function upcomingSchedules()
    {
        return $this->hasMany(TourSchedule::class, 'tour_id')
                    ->whereDate('departure_date', '>=', now())
                    ->where('status', 'open')
                    ->orderBy('departure_date');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'tour_id');
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class, 'tour_id')->where('approved', true);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * % giảm giá dựa trên price_original và price_adult
     */
    public function getDiscountPercentAttribute()
    {
        if ($this->price_original && $this->price_original > 0) {
            return round((($this->price_original - $this->price_adult) / $this->price_original) * 100);
        }

        return 0;
    }

    /**
     * Format tiền để hiển thị trực tiếp trong view (Ví dụ: "4.500.000 đ")
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price_adult, 0, ',', '.') . ' đ';
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS LOGIC
    |--------------------------------------------------------------------------
    */

    /**
     * Tạo slug duy nhất
     */
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

    /**
     * Tính lại rating trung bình và count khi có review mới/được duyệt
     */
    public function recalculateRating()
    {
        $agg = $this->approvedReviews()
                    ->selectRaw('AVG(rating) as avg, COUNT(*) as cnt')
                    ->first();

        $this->rating_avg = round($agg->avg ?? 0, 2);
        $this->rating_count = $agg->cnt ?? 0;
        $this->save();
    }

    /**
     * Trả về ảnh hiển thị chính (dùng trong view). Nếu không có, trả null.
     */
    public function getPrimaryImageUrlAttribute()
    {
        $img = $this->primaryImage()->first() ?? $this->images()->first();
        return $img ? asset('storage/' . $img->path) : null;
    }
}