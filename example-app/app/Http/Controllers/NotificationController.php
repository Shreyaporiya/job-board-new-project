<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\InvoicePaid;

class NotificationController extends Controller
{
    public function sendNotification()
    {
        $user = User::first(); // send to first user in DB

        if (!$user) {
            return 'No user found! Please register one.';
        }

        $invoiceDetails = [
            'invoice_id' => 101,
            'amount' => 999,
        ];

        
        // Send queued notification
        $user->notify(new InvoicePaid($invoiceDetails));

        return 'Notification added to queue successfully!';
    }
}
