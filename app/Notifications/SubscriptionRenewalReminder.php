<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionRenewalReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $subscription;

    public $daysLeft;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription, int $daysLeft)
    {
        $this->subscription = $subscription;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $renewUrl = route('billing.choose-plan');

        return (new MailMessage)
            ->subject('Subscription Renewal Reminder - '.$this->subscription->school->name)
            ->greeting('Hello '.$notifiable->name.',')
            ->line("Your school's subscription for the '{$this->subscription->plan->name}' plan will expire in {$this->daysLeft} days.")
            ->line('To ensure uninterrupted access to the School ERP, please renew your subscription.')
            ->action('Renew Subscription', $renewUrl)
            ->line('Thank you for choosing our School ERP!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Subscription Expiring Soon',
            'message' => "Your subscription will expire in {$this->daysLeft} days.",
            'subscription_id' => $this->subscription->id,
            'days_left' => $this->daysLeft,
            'action_url' => route('billing.choose-plan'),
        ];
    }
}
