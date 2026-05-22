<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriptionReminder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendSubscriptionReminderCommand extends Command
{
    protected $signature = 'subscription:send-reminders';
    protected $description = 'Send subscription reminders to users';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow();
        $users = User::whereDate('subscription_end_date', $tomorrow)->get();

        foreach ($users as $user) {
            SendSubscriptionReminder::dispatch($user);
        }

        $this->info('Subscription reminder emails dispatched!');
    }
}
