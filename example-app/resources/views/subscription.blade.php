@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-md-10">

                <h2 class="text-center mb-5">
                    Choose Subscription Plan
                </h2>

                <div class="row">

                    <!-- Basic -->
                    <div class="col-md-4 mb-4">

                        <div class="card shadow h-100">

                            <div class="card-body text-center">

                                <h3>Basic Plan</h3>

                                <h1 class="my-4">$5</h1>

                                <p>
                                    Basic access for matrimonial features.
                                </p>

                                <form action="{{ route('subscription.checkout') }}" method="POST">

                                    @csrf

                                    <input type="hidden" name="price_id" value="price_1TbH2tHGlhao1xSrZXAva2bW">

                                    <button class="btn btn-primary w-100">
                                        Subscribe
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                    <!-- Premium -->
                    <div class="col-md-4 mb-4">

                        <div class="card shadow h-100">

                            <div class="card-body text-center">

                                <h3>Premium Plan</h3>

                                <h1 class="my-4">$15</h1>

                                <p>
                                    Premium profile and unlimited access.
                                </p>

                                <form action="{{ route('subscription.checkout') }}" method="POST">

                                    @csrf

                                    <input type="hidden" name="price_id" value="price_1TbH7ZHGlhao1xSrH2CER1jy">

                                    <button class="btn btn-success w-100">
                                        Subscribe
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                    <!-- Platinum -->
                    <div class="col-md-4 mb-4">

                        <div class="card shadow h-100">

                            <div class="card-body text-center">

                                <h3>Platinum Plan</h3>

                                <h1 class="my-4">$30</h1>

                                <p>
                                    Full premium matrimonial access.
                                </p>

                                <form action="{{ route('subscription.checkout') }}" method="POST">

                                    @csrf

                                    <input type="hidden" name="price_id" value="price_1TbH2tHGlhao1xSrZXAva2bW">

                                    <button class="btn btn-dark w-100">
                                        Subscribe
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection