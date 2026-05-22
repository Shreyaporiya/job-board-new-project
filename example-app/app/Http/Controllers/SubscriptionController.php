<?php

namespace App\Http\Controllers;

use App\Jobs\SendSubscriptionReminder;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function sendReminders()
    {
        $tomorrow = Carbon::tomorrow();

        $users = User::whereDate('subscription_end_date', $tomorrow)->get();

        foreach ($users as $user) {
            SendSubscriptionReminder::dispatch($user);
        }

        return "Subscription reminders added to queue!";
    }
}