<?php

namespace App\Models\Client;
use App\Notifications\VerifyAccountNotification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'phone_verified_at',
        'address',
        'role',
        'avatar_url',
        'last_login_at',
        'is_active',
        'cccd',
        'cccd_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'cccd_verified_at' => 'datetime',

        ];
    }
    public function sendEmailVerificationNotification()
        {
            $this->notify(new VerifyAccountNotification());
        }
    public function activationTokenValid($minutes = 60)
        {
            if (!$this->activation_token_created_at) {
                return false;
            }

            $createdAt = \Carbon\Carbon::parse($this->activation_token_created_at);

            return $createdAt->gt(now()->subMinutes($minutes));
        }
        public function setCccdAttribute($value)
        {
            if ($value) {
                // Lưu encrypted
                $this->attributes['cccd'] = Crypt::encryptString($value);

                // Lưu hash để unique + tìm kiếm
                $this->attributes['cccd_hash'] = hash('sha256', $value);
            } else {
                $this->attributes['cccd'] = null;
                $this->attributes['cccd_hash'] = null;
            }
        }
        public function getCccdAttribute($value)
        {
            return $value ? Crypt::decryptString($value) : null;
        }
        public function getMaskedCccdAttribute()
    {
        if (!$this->cccd) {
            return null;
        }

        $cccd = $this->cccd; // đã được decrypt từ accessor trước đó
        $length = strlen($cccd);

        // Nếu ngắn bất thường
        if ($length <= 4) {
            return str_repeat('*', $length);
        }

        // Chỉ hiển thị 4 số cuối
        $visibleDigits = 4;

        return str_repeat('*', $length - $visibleDigits) 
            . substr($cccd, -$visibleDigits);
    }

}
