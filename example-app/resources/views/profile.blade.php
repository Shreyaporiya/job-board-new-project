@if(auth()->user()->subscribed('default'))

    @php

        $subscription = auth()->user()->subscription('default');

        $priceId = $subscription->stripe_price ?? '';

        $plan = match ($priceId) {

            'price_1TbH7ZHGlhao1xSrH2CER1jy' => 'Basic Plan',

            'price_1TbH2tHGlhao1xSrZXAva2bW' => 'Premium Plan',

            'price_platinum_plan_id' => 'Platinum Plan',

            default => 'Unknown Plan'
        };

    @endphp

    <div class="card shadow p-4 mt-4">

        <h3 class="mb-4">
            Subscription Details
        </h3>

        <p>
            <strong>Plan:</strong>
            {{ $plan }}
        </p>

        <p>
            <strong>Status:</strong>
            Active
        </p>

        <p>
            <strong>Stripe Price ID:</strong>
            {{ $priceId }}
        </p>

        <p>
            <strong>Subscription Ends:</strong>

            {{ $subscription->ends_at
            ? $subscription->ends_at->format('d M Y')
            : 'Auto Renew Enabled'
                        }}
        </p>

    </div>

@else

    <div class="alert alert-danger mt-4">

        No Active Subscription

    </div>

@endif