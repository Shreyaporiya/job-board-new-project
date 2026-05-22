<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        $details = [
            'title' => 'Mail from Laravel App',
            'body' => 'This is a test email sent using Laravel Mail feature.'
        ];

        Mail::to('shreyaporiya08@gmail.com')->send(new DemoMail($details));

        return "Email has been sent successfully!";
    }
}
