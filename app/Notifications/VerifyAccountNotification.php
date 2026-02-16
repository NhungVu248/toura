<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class VerifyAccountNotification extends Notification
{
    protected $token;

    public function __construct($token = null)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Build activation URL (named route 'auth.activate')
        $activationUrl = route('auth.activate', ['token' => $this->token]);

        return (new MailMessage)
            ->subject('Kích hoạt tài khoản Travel Booking')
            ->greeting('Xin chào ' . ($notifiable->name ?? 'Bạn'))
            ->line('Cảm ơn bạn đã đăng ký tài khoản trên Travel Booking.')
            ->line('Nhấn nút bên dưới để kích hoạt tài khoản của bạn:')
            ->action('Kích hoạt tài khoản', $activationUrl)
            ->line('Link này sẽ hết hạn sau 60 phút.')
            ->salutation('Trân trọng, Travel Booking Team');
    }
}
