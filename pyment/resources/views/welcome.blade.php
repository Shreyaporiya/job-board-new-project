<!DOCTYPE html>
<html >
<head>

    <title>Laravel Stripe Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="card p-5 text-center">

        <h1 class="mb-4">
            Stripe Payment Gateway
        </h1>

        <h3 class="mb-4">
            $10 Payment
        </h3>

        <form action="{{ route('checkout') }}" method="POST">

            @csrf

            <button class="btn btn-primary btn-lg">
                Pay Now
            </button>

        </form>

    </div>

</div>

</body>
</html>