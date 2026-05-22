<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reportData;

    /**
     * Create a new message instance.
     */
    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('📊 Daily Report Summary')
                    ->view('emails.daily_report');
    }
}
