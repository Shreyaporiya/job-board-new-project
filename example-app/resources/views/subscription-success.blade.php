@extends('layouts.app')

@section('content')

    <div class="container py-5 text-center">

        <h1 class="text-success">
            Payment Successful
        </h1>

        <p>
            Your subscription is active now.
        </p>

        <a href="/profile" class="btn btn-primary">
            Go To Profile
        </a>

    </div>

@endsection