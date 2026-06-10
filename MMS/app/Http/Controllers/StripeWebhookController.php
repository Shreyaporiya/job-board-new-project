<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscription;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PaymentFailedNotification;

class StripeWebhookController extends CashierController
{

    public function handleWebhook(Request $request)
    {
        return parent::handleWebhook($request);
    }

    public function handleCheckoutSessionCompleted(array $payload)
    {
        try {

            $session = $payload['data']['object'];

            $userId = $session['metadata']['user_id'] ?? null;
            $planId = $session['metadata']['plan_id'] ?? null;

            if (!$userId || !$planId) {
                return parent::successMethod();
            }

            $user = User::find($userId);
            $plan = Plan::find($planId);

            if (!$user || !$plan) {
                return parent::successMethod();
            }

            // CREATE PENDING PAYMENT
            Payment::updateOrCreate(
                [
                    'stripe_payment_id' => $session['payment_intent'] ?? $session['id'],
                ],
                [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'amount' => ($session['amount_total'] ?? 0) / 100,
                    'payment_status' => 'Pending',
                    'paid_at' => null,
                    'failure_reason' => null,
                ]
            );

            $user->update([
                'role' => 'User',
                'plan' => $plan->name,
            ]);

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }

    /* Subscription Deleted */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        try {

            $subscription = $payload['data']['object'];

            $user = User::where(
                'stripe_id',
                $subscription['customer']
            )->first();

            if ($user) {

                $user->update([
                    'role' => 'Free',
                    'plan' => 'free',
                ]);
            }

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }

    /* Invoice Payment Succeeded */
    public function handleInvoicePaymentSucceeded(array $payload)
    {
        sleep(20);

        try {

            $invoice = $payload['data']['object'];

            $user = User::where('stripe_id', $invoice['customer'])->first();

            if (!$user) {
                return parent::successMethod();
            }

            $subscription = $user->subscription('default');

            if (!$subscription) {
                return parent::successMethod();
            }

            $plan = Plan::where('stripe_price_id', $subscription->stripe_price)->first();

            if (!$plan) {
                return parent::successMethod();
            }

            Payment::updateOrCreate(
                [
                    'stripe_payment_id' => $invoice['payment_intent'] ?? $invoice['id']
                ],
                [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'amount' => ($invoice['amount_paid'] ?? 0) / 100,
                    'payment_status' => 'Paid',
                    'failure_reason' => null,
                    'paid_at' => now(),
                ]
            );

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }

    /* Invoice Payment Failed */
    public function handleInvoicePaymentFailed(array $payload)
    {
        try {

            $invoice = $payload['data']['object'];

            $user = User::where('stripe_id', $invoice['customer'])->first();

            if (!$user) {
                return parent::successMethod();
            }

            Payment::updateOrCreate(
                [
                    'stripe_payment_id' => $invoice['payment_intent'] ?? $invoice['id']
                ],
                [
                    'user_id' => $user->id,
                    'plan_id' => null,
                    'amount' => ($invoice['amount_due'] ?? 0) / 100,
                    'payment_status' => 'Failed',
                    'failure_reason' =>
                        $invoice['last_finalization_error']['message']
                        ?? 'Payment failed',
                    'paid_at' => null,
                ]
            );

            $user->notify(new PaymentFailedNotification());

        } catch (\Exception $e) {
            report($e);
        }

        return parent::successMethod();
    }
}