<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE NAME
    |--------------------------------------------------------------------------
    | Laravel mặc định đoán tên bảng là "contacts"
    | Nhưng bảng của bạn là "tbl_contacts"
    | nên phải khai báo lại
    */

    protected $table = 'tbl_contacts';


    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    | Mặc định Laravel dùng id nên không cần khai báo
    */

    protected $primaryKey = 'id';


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNABLE
    |--------------------------------------------------------------------------
    | Những field cho phép insert/update bằng create() hoặc update()
    */

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'message',
        'status',
        'admin_reply',
        'replied_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTING DATE
    |--------------------------------------------------------------------------
    | Laravel sẽ tự convert các field này sang Carbon object
    | giúp format ngày dễ dàng
    */

    protected $casts = [
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS
    |--------------------------------------------------------------------------
    | Tạo constants giúp code rõ ràng hơn
    */

    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REPLIED = 'replied';
    const STATUS_CLOSED = 'closed';


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    | Query helper giúp filter nhanh
    */

    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopeReplied($query)
    {
        return $query->where('status', self::STATUS_REPLIED);
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    | Format ngày hiển thị
    */

    public function getCreatedDateAttribute()
    {
        return $this->created_at
            ? $this->created_at->format('d/m/Y H:i')
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    | Kiểm tra trạng thái contact
    */

    public function isReplied()
    {
        return $this->status === self::STATUS_REPLIED;
    }

}