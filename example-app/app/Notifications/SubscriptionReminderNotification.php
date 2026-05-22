<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $daysLeft)
    {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Your subscription expires in {$this->daysLeft} days")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your subscription will expire in {$this->daysLeft} days.")
            ->line("Please renew your plan to continue using premium features.")
            ->action('Renew Now', url('/subscriptions/renew'))
            ->line('Thank you for being a valued user!');
    }
}
