<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaid extends Notification implements ShouldQueue
{
    use Queueable;

    public $invoiceDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoiceDetails)
    {
        $this->invoiceDetails = $invoiceDetails;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // send via email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Invoice Paid Successfully!')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your invoice #' . $this->invoiceDetails['invoice_id'] . ' has been successfully paid.')
            ->line('Amount: ₹' . $this->invoiceDetails['amount'])
            ->action('View Invoice', url('/invoices/' . $this->invoiceDetails['invoice_id']))
            ->attach('/app/public/uploads/panda.jpg') // ✔ this is valid
            ->line('Thank you for your business!');

    }
}
