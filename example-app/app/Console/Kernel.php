<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\DailyReportCommand;
use App\Jobs\SendSubscriptionReminderJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run daily at 10 AM
        $schedule->command('report:daily')
            ->dailyAt('10:00')
            ->appendOutputTo(storage_path('logs/daily_report.log'));

        // Example of another scheduled closure
        $schedule->call(function () {
            \Log::info('🧹 Cleaned up temporary files at ' . now());
        })->dailyAt('02:00');

        // Run daily at 9 AM
        $schedule->job(new SendSubscriptionReminderJob)
             ->dailyAt('17:30');

        $schedule->command('subscription:send-reminders')->dailyAt('18:10');

        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');


        require base_path('routes/console.php');
    }
}
