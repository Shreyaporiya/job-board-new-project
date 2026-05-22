<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class SmsNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['sms'];
    }

    /**
     * Send SMS via Twilio.
     */
    public function toSms($notifiable)
    {
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $from   = env('TWILIO_FROM');
        $to     = '+917327914172'; // Make sure user model has 'phone' field

        $client = new Client($sid, $token);
        $client->messages->create($to, [
            'from' => $from,
            'body' => $this->message
        ]);
    }
}
