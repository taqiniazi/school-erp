<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Models\Notice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNoticeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $notice;

    /**
     * Create a new notification instance.
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['mail', 'database'];

        // Add SMS channel if user has phone number
        if (! empty($notifiable->phone_number)) {
            $channels[] = SmsChannel::class;
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Notice: '.$this->notice->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('A new notice has been posted:')
            ->line($this->notice->title)
            ->line('Type: '.ucfirst($this->notice->type))
            ->action('View Notice', route('communication.notices.show', $this->notice))
            ->line('Thank you for using our School ERP.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'notice_id' => $this->notice->id,
            'title' => $this->notice->title,
            'type' => $this->notice->type,
            'url' => route('communication.notices.show', $this->notice),
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): string
    {
        return "New Notice: {$this->notice->title}. View at: ".route('communication.notices.show', $this->notice);
    }
}
