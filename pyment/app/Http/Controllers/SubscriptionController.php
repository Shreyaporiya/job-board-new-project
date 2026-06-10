<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscriptions');
    }

    public function checkout($priceId)
    {
        return auth()->user()
            ->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('subscription.cancel'),
            ]);
    }

    public function success()
    {
        return view('success');
    }

    public function cancel()
    {
        auth()->user()
            ->subscription('default')
            ->cancelNow();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Subscription Cancelled');
    }
}