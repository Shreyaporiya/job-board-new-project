<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DailyReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * You will use this in schedule() and artisan.
     *
     * Example: php artisan report:daily
     */
    protected $signature = 'report:daily';

    /**
     * The console command description.
     *
     * This will appear when you run php artisan list
     */
    protected $description = 'Generate the daily report and log it in the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Here you can put logic like sending email, generating PDFs, etc.
        // For simplicity, we just log a message.
        Log::info('✅ Daily Report Generated Successfully at ' . now());

        $this->info('Daily Report Generated Successfully!');
    }
}
