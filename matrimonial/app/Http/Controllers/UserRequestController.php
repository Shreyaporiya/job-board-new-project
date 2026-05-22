<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\Models\Profile;
use App\Notifications\UserRequestNotification;
use Illuminate\Support\Facades\Auth;

class UserRequestController extends Controller
{
    /* ===== RECEIVED REQUESTS ===== */
    public function index()
    {
        $myProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        $requests = UserRequest::with('sender.user', 'sender.images')
            ->where('receiver_id', $myProfile->id)
            ->where('is_pending', 1)
            ->latest()
            ->get();

        return view('requests.index', compact('requests'));
    }

    /* ===== SENT REQUESTS ===== */
    public function viewrequests()
    {
        $myProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        $requests = UserRequest::with('receiver.user', 'receiver.images')
            ->where('sender_id', $myProfile->id)
            ->latest()
            ->get();

        return view('requests.sent', compact('requests'));
    }

    /* ===== SEND REQUEST ===== */
    public function send($receiverProfileId)
    {
        $senderProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        $receiverProfile = Profile::findOrFail($receiverProfileId);

        $request = UserRequest::updateOrCreate(
            [
                'sender_id' => $senderProfile->id,
                'receiver_id' => $receiverProfile->id,
            ],
            [
                'is_pending' => 1,
                'is_accepted' => 0,
                'is_rejected' => 0,
                'is_canceled' => 0,
                'is_blocked' => 0,
            ]
        );

        // 🔔 Notify Receiver → Redirect to received requests
        $receiverProfile->user->notify(
            new UserRequestNotification(
                Auth::user()->name . ' sent you a request 💌',
                route('request.index')
            )
        );

        return back()->with('success', 'Request sent 💌');
    }

    /* ===== ACCEPT ===== */
    public function accept($id)
    {
        $myProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        $request = UserRequest::where('id', $id)
            ->where('receiver_id', $myProfile->id)
            ->firstOrFail();

        $request->update([
            'is_accepted' => 1,
        ]);

        // 🔔 Notify Sender → Redirect to sent requests
        $request->sender->user->notify(
            new UserRequestNotification(
                Auth::user()->name . ' accepted your request 💖',
                route('request.view')
            )
        );

        return back()->with('success', 'Request accepted 💖');
    }

    /* ===== REJECT ===== */
    public function reject($id)
    {
        $myProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        $request = UserRequest::where('id', $id)
            ->where('receiver_id', $myProfile->id)
            ->firstOrFail();

        $request->update([
            'is_rejected' => 1,
        ]);

        $request->sender->user->notify(
            new UserRequestNotification(
                Auth::user()->name . ' rejected your request ❌',
                route('request.view')
            )
        );

        return back()->with('info', 'Request rejected ❌');
    }

    /* ===== CANCEL ===== */
    public function cancel($id)
    {
        $myProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        $request = UserRequest::where('id', $id)
            ->where('sender_id', $myProfile->id)
            ->firstOrFail();

        $request->update([
            'is_canceled' => 1,
        ]);

        $request->receiver->user->notify(
            new UserRequestNotification(
                Auth::user()->name . ' canceled the request 🚫',
                route('request.index')
            )
        );

        return back()->with('info', 'Request canceled 🚫');
    }

    /* ===== BLOCK ===== */
    public function block($requestId)
    {
        $myProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        $request = UserRequest::where('id', $requestId)
            ->where('receiver_id', $myProfile->id)
            ->firstOrFail();

        $request->update([
            'is_blocked' => 1,
        ]);

        $request->sender->user->notify(
            new UserRequestNotification(
                'You have been blocked ⛔',
                route('dashboard')
            )
        );

        return back()->with('success', 'User blocked successfully ⛔');
    }


    public function remove($requestId)
    {
        $myProfile = Profile::where('user_id', Auth::id())->firstOrFail();

        $userRequest = UserRequest::where('id', $requestId)
            ->where('sender_id', $myProfile->id)
            ->firstOrFail();

        $userRequest->delete();

        return redirect()
            ->route('request.view')
            ->with('success', 'User request removed successfully 🗑️');
    }

}
