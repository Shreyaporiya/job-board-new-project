<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\SubscriptionReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSubscriptionReminderJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function handle()
    {
        // Find users whose subscription expires in next 3 days
        $users = User::whereDate('subscription_end', now()->addDays(3))->get();

        foreach ($users as $user) {
            $daysLeft = now()->diffInDays($user->subscription_end);
            $user->notify(new SubscriptionReminderNotification($daysLeft));
        }
    }
}
