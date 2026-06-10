@extends('layouts.app')

@section('content')

    <div class="container py-5 text-center">

        <h1 class="text-danger">
            Payment Cancelled
        </h1>

        <p>
            Your payment was cancelled.
        </p>

        <a href="/subscription" class="btn btn-dark">
            Try Again
        </a>

    </div>

@endsection