<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use App\Notifications\FriendRequestResponseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    /*------------------------------------------
        PAGE: LIST ALL USERS
    -------------------------------------------*/
    public function users()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /*------------------------------------------
        SEND FRIEND REQUEST
    -------------------------------------------*/
    public function sendRequest($receiverId)
    {
        if ($receiverId == Auth::id()) {
            return back()->with('error', 'You cannot send a request to yourself.');
        }

        // Check duplicate/active requests
        $exists = FriendRequest::where('sender_id', Auth::id())
            ->where('receiver_id', $receiverId)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Request already sent!');
        }

        FriendRequest::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Friend Request Sent!');
    }

    /*------------------------------------------
        ACCEPT REQUEST
    -------------------------------------------*/
    public function accept($id)
    {
        $req = FriendRequest::findOrFail($id);

        if ($req->receiver_id != Auth::id()) {
            abort(403);
        }

        $req->update(['status' => 'accepted']);

        // Notify sender
        $req->sender->notify(
            new FriendRequestResponseNotification(Auth::user()->name . ' accepted your request.')
        );

        return back()->with('success', 'Request Accepted');
    }

    /*------------------------------------------
        REJECT REQUEST
    -------------------------------------------*/
    public function reject($id)
    {
        $req = FriendRequest::findOrFail($id);

        if ($req->receiver_id != Auth::id()) {
            abort(403);
        }

        $req->update(['status' => 'rejected']);

        // Notify sender
        $req->sender->notify(
            new FriendRequestResponseNotification(Auth::user()->name . ' rejected your request.')
        );

        return back()->with('success', 'Request Rejected');
    }

    /*------------------------------------------
        BLOCK REQUEST
    -------------------------------------------*/
    public function block($id)
    {
        $req = FriendRequest::findOrFail($id);

        if ($req->receiver_id != Auth::id()) {
            abort(403);
        }

        $req->update(['status' => 'blocked']);

        return back()->with('success', 'User Blocked Successfully');
    }

    /*------------------------------------------
        VIEW: INCOMING REQUESTS
    -------------------------------------------*/
    public function incoming()
    {
        $incomingRequests = FriendRequest::where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        return view('requests.incoming', compact('incomingRequests'));
    }

    /*------------------------------------------
        VIEW: OUTGOING REQUESTS
    -------------------------------------------*/
    public function outgoing()
    {
        $outgoingRequests = FriendRequest::where('sender_id', Auth::id())->get();

        return view('requests.outgoing', compact('outgoingRequests'));
    }

    /*------------------------------------------
        VIEW: NOTIFICATIONS
    -------------------------------------------*/
    public function notifications()
    {
        return view('notifications.index');
    }
}
