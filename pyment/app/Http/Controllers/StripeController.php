<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Payment;

class StripeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function checkout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',

                        'product_data' => [
                            'name' => 'Laravel Stripe Payment',
                        ],

                        'unit_amount' => 1000,
                    ],

                    'quantity' => 1,
                ]
            ],

            'mode' => 'payment',

            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',

            'cancel_url' => route('cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session_id = $request->get('session_id');

        $session = Session::retrieve($session_id);

        Payment::create([
            'payment_id' => $session->payment_intent,
            'customer_email' => $session->customer_details->email,
            'amount' => $session->amount_total,
            'currency' => $session->currency,
            'payment_status' => $session->payment_status,
        ]);

        return view('success');
    }

    public function cancel()
    {
        return view('cancel');
    }
}