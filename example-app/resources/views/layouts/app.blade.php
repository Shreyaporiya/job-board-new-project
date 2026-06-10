<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimonial System</title>

    <!-- Logo in titlebar -->
    <link rel="icon" href="{{ asset('images/logo3.ico') }}" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom CSS -->
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand" href="/">
                Matrimonial Site
            </a>

            <a class="nav-link text-white" href="/profiles">
                Browse Profiles
            </a>

            <div>

                @auth

                    @if(auth()->user()->subscribed('default'))

                        <span class="badge bg-success">
                            Premium Member
                        </span>

                    @else

                        <a href="/subscription" class="btn btn-warning">
                            Buy Membership
                        </a>

                    @endif

                @endauth

            </div>
        </div>
    </nav>

    <!-- Header -->

    <!-- Main Content -->
    <main style="padding-top: 7%; padding-bottom: 0%;">
        <!-- Featured Profiles -->
        @yield('content')
    </main>

    <!-- Footer -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>