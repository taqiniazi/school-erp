<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toSms')) {
            return;
        }

        $message = $notification->toSms($notifiable);

        // In a real application, you would use an SMS service like Twilio, Vonage, etc.
        // For this demo, we will log the SMS content to the application log.
        Log::info("SMS sent to {$notifiable->phone_number}: {$message}");
    }
}
