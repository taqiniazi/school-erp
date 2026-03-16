<?php

namespace App\Notifications;

use App\Models\SubscriptionPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(SubscriptionPayment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status = ucfirst($this->payment->status);
        $planName = $this->payment->plan->name;
        $amount = number_format($this->payment->amount, 2);

        $message = (new MailMessage)
            ->subject("Payment Status Update: {$status}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your subscription payment for the **{$planName}** plan has been **{$status}**.")
            ->line("Amount: {$amount}")
            ->line("Transaction Reference: {$this->payment->transaction_reference}");

        if ($this->payment->status === 'approved') {
            $message->line('Your subscription is now active. You can access all premium features immediately.')
                ->action('View Invoice', route('billing.history'));
        } elseif ($this->payment->status === 'rejected') {
            $message->line('Reason for rejection: '.($this->payment->admin_note ?? 'Not specified'))
                ->line('Please contact support or try again.')
                ->action('View Payment History', route('billing.history'));
        }

        return $message->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'status' => $this->payment->status,
            'message' => "Payment for plan {$this->payment->plan->name} was {$this->payment->status}.",
        ];
    }
}
