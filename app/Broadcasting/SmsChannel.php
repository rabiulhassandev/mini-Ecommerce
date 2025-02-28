<?php

namespace App\Broadcasting;

// use App\Models\User;
use App\Jobs\SmsOneToOne;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        if ($notifiable->phone) SmsOneToOne::dispatch($notifiable->phone, $message);
    }
}
