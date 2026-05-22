<x-guest-layout>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom right, #fdf3e6, #fbe9d3, #f8d7c4) !important;
        }

        .left-section {
            background: linear-gradient(to bottom right, #7a1f28, #b44a4f) !important;
            color: #fff !important;
        }

        .left-section .icon-check {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            color: #ffd65a !important;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9) !important;
            border-radius: 20px;
            backdrop-filter: blur(6px);
            border: 1px solid #e3c7a0 !important;
        }

        .btn-maroon {
            background-color: #7a1f28 !important;
            color: white !important;
        }

        .btn-maroon:hover {
            background-color: #9d2b34 !important;
        }

        /* Decorative Circles */
        .circle-lg {
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.12) !important;
            border-radius: 50%;
            top: -40px;
            right: -40px;
        }

        .circle-sm {
            position: absolute;
            width: 110px;
            height: 110px;
            background: rgba(255, 255, 255, 0.12) !important;
            border-radius: 50%;
            bottom: -40px;
            left: -40px;
        }
    </style>

    <div class="container vh-100 d-flex justify-content-center align-items-center py-5">

        <div class="row login-card shadow-lg overflow-hidden" style="max-width: 900px; width: 100%;">

            <!-- Left Side -->
            <div class="col-md-6 left-section p-5 d-none d-md-flex flex-column justify-content-center position-relative">

                <h2 class="fw-bold mb-3">Welcome Back!</h2>
                <p class="mb-4 opacity-75">
                    Sign in to continue your journey on SoulMate and reconnect with your potential life partner.
                </p>

                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-3">
                        <svg class="icon-check" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414L9 14.414l-3.707-3.707a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Secure & verified accounts
                    </li>

                    <li class="d-flex align-items-center mb-3">
                        <svg class="icon-check" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414L9 14.414l-3.707-3.707a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Privacy-focused platform
                    </li>

                    <li class="d-flex align-items-center mb-3">
                        <svg class="icon-check" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414L9 14.414l-3.707-3.707a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        24/7 support & guidance
                    </li>
                </ul>

                <div class="circle-lg"></div>
                <div class="circle-sm"></div>
            </div>

            <!-- Right Side Form -->
            <div class="col-md-6 p-5">

                <h2 class="text-center mb-4 fw-bold" style="color: #7a1f28;">
                    Login to Your Account
                </h2>

                <!-- Session Messages -->
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:#7a1f28;">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required>

                        @error('email')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:#7a1f28;">Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required>

                        @error('password')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                        <label class="form-check-label fw-medium" for="remember_me" style="color:#7a1f28;">
                            Remember me
                        </label>
                    </div>

                    <!-- Forgot Password -->
                    @if (Route::has('password.request'))
                        <div class="mb-3">
                            <a href="{{ route('password.request') }}" style="color:#7a1f28;" class="text-decoration-none">
                                Forgot your password?
                            </a>
                        </div>
                    @endif

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-maroon w-100 py-2 fw-semibold">
                        Log In
                    </button>

                    <!-- Register -->
                    <p class="text-center mt-3" style="color:#7a1f28;">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="fw-semibold" style="color:#7a1f28;">Register</a>
                    </p>



                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</x-guest-layout>
