<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class OTPNotificationViaEmail extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // Send OTP via email
    }

    /**
     * Send OTP via email.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your OTP Code')
            ->greeting('Hello ' . $this->user->name . ',')
            ->line('Your OTP code for password reset is: **' . $this->user->otp . '**')
            ->line('This OTP will expire in ' . config('otp.expiry') . ' minutes.')
            ->line('If you did not request this, please ignore this email.')
            ->salutation('Regards, ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'otp' => $this->user->otp,
        ];
    }
}
