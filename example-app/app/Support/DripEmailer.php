<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class DripEmailer
{
    public function send(User $user)
    {
        // Example: send a simple email
        Mail::raw("Hello {$user->name}, this is a marketing email!", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Marketing Email');
        });
    }
}
