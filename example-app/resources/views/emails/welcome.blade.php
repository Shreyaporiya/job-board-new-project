


<!DOCTYPE html>
<html>
<head>
    <title>laravel1</title>
</head>

<body>
    <div>
        @component('mail::message')
        # Hello {{ $user->name }}

        Welcome to our platform. We're happy to have you!

        Thanks,<br>
        {{ config('app.name') }}
        @endcomponent
    </div>
</body>
</html>