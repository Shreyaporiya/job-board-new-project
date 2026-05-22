<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserRequestStatusNotification extends Notification
{
    use Queueable;

    public $status;
    public $senderName;
    public $receiverName;

    public function __construct($status, $senderName, $receiverName)
    {
        $this->status = $status;
        $this->senderName = $senderName;
        $this->receiverName = $receiverName;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // store in DB
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => "{$this->receiverName} has {$this->status} your request.",
        ];
    }
}
