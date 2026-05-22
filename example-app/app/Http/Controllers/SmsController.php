<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SmsNotification;

class SmsController extends Controller
{
    public function sendSms()
    {
        $user = User::find(1); // Example user

        $user->notify(new SmsNotification("Hello! This is a test SMS from Laravel."));

        return "SMS sent!";
    }
}
