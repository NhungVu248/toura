<?php

namespace App\Models\Client;
use App\Notifications\VerifyAccountNotification;

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
}
