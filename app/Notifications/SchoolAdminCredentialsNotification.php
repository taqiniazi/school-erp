<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchoolAdminCredentialsNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $schoolName,
        public string $email,
        public string $password,
        public string $loginUrl,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your School ERP Admin Account')
            ->greeting('Hello '.$notifiable->name.',')
            ->line('A School Admin account has been created for you on the School ERP SaaS platform.')
            ->line('School: '.$this->schoolName)
            ->line('Email: '.$this->email)
            ->line('Password: '.$this->password)
            ->action('Login', $this->loginUrl)
            ->line('After logging in, you will be asked to select a subscription plan before using the ERP.');
    }
}
