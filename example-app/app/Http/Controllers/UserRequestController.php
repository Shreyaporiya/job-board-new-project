<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRequest;
use App\Models\User;

class UserRequestController extends Controller
{
    // Show all users (for sending requests)
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get(); // all except logged-in
        return view('users.index', compact('users'));
    }

    // Send a request to a user
    public function send($receiver_id)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to send a request.');
    }

    $sender_id = auth()->id();

    if ($receiver_id == $sender_id) {
        return back()->with('error', 'Cannot send request to yourself.');
    }

    $existing = UserRequest::where('sender_id', $sender_id)
                           ->where('receiver_id', $receiver_id)
                           ->first();

    if ($existing) {
        return back()->with('error', 'Request already sent.');
    }

    UserRequest::create([
        'sender_id'   => $sender_id,
        'receiver_id' => $receiver_id,
        'status'      => 'pending',
    ]);

    return back()->with('success', 'Request sent successfully!');
}

}
