<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UserRequest;  // ✅ ADD THIS
use App\Models\User;         // ✅ ADD THIS
use App\Notifications\UserRequestStatusNotification; // ✅ ADD THIS

class SendNotificationController extends Controller
{
    public function accept($id)
    {
        $userrequest = UserRequest::findOrFail($id);

        if ($userrequest->receiver_id != auth()->id()) {
            abort(403);
        }

        $userrequest->update(['status' => 'accepted']);

        // Notify Sender
        $sender = User::find($userrequest->sender_id);
        $receiver = auth()->user();

        $sender->notify(
            new UserRequestStatusNotification('accepted', $sender->name, $receiver->name)
        );

        return back()->with('success', 'Request Accepted');
    }

    public function reject($id)
    {
        $userrequest = UserRequest::findOrFail($id);

        if ($userrequest->receiver_id != auth()->id()) {
            abort(403);
        }

        $userrequest->update(['status' => 'rejected']);

        // Notify sender
        $sender = User::find($userrequest->sender_id);
        $receiver = auth()->user();

        $sender->notify(
            new UserRequestStatusNotification('rejected', $sender->name, $receiver->name)
        );

        return back()->with('error', 'Request Rejected');
    }

    public function block($id)
    {
        $userrequest = UserRequest::findOrFail($id);

        if ($userrequest->receiver_id != auth()->id()) {
            abort(403);
        }

        $userrequest->update(['status' => 'blocked']);

        // Notify sender
        $sender = User::find($userrequest->sender_id);
        $receiver = auth()->user();

        $sender->notify(
            new UserRequestStatusNotification('blocked', $sender->name, $receiver->name)
        );

        return back()->with('info', 'User Blocked');
    }
}
