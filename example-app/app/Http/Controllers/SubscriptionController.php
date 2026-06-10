<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function checkout(Request $request)
    {
        $priceId = $request->price_id;

        return $request->user()
            ->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('subscription.cancel'),
            ]);
    }

    public function success()
    {
        return view('subscription-success');
    }

    public function cancel()
    {
        return view('subscription-cancel');
    }
}