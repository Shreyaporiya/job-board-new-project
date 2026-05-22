<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimonial Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="pt-5">

    @include('user.layouts.header')

    <main class="container my-5">
        @yield('content')
    </main>

    @include('user.layouts.footer')
</body>
</html>
