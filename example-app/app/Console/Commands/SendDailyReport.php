<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;

class SendDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Example: php artisan report:send
     */
    protected $signature = 'report:send';

    /**
     * The console command description.
     */
    protected $description = 'Send a daily report email to the admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fake report data (you can pull this from DB)
        $reportData = [
            'users' => 150,
            'orders' => 32,
            'revenue' => 18500
        ];

        // Send email
        Mail::to('testtest95107@gmail.com')->send(new DailyReportMail($reportData));

        $this->info('✅ Daily Report Email Sent Successfully!');
    }
}
