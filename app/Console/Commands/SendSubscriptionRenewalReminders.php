<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SubscriptionRenewalReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendSubscriptionRenewalReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:send-renewal-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send renewal reminders to schools with subscriptions expiring soon.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting subscription renewal reminders check...');

        // Days to check: 7 days and 3 days before expiry
        $daysToCheck = [7, 3];

        foreach ($daysToCheck as $days) {
            $targetDate = now()->addDays($days)->startOfDay();
            
            $subscriptions = Subscription::where('status', 'active')
                ->whereDate('current_period_end', $targetDate)
                ->with(['school', 'plan'])
                ->get();

            $count = 0;
            foreach ($subscriptions as $subscription) {
                $admins = User::role('School Admin')
                    ->where('school_id', $subscription->school_id)
                    ->get();

                if ($admins->isNotEmpty()) {
                    Notification::send($admins, new SubscriptionRenewalReminder($subscription, $days));
                    $count++;
                }
            }
            
            $this->info("Sent {$count} reminders for subscriptions expiring in {$days} days.");
        }

        $this->info('Renewal reminders check completed.');
    }
}
