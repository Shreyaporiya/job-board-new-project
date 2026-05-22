<!DOCTYPE html>
<html>
<body>
    <h2>Hello {{ $user->name }},</h2>

    <p>Your subscription will expire on <strong>{{ $user->subscription_end_date }}</strong>.</p>

    <p>Please renew your subscription to continue using our services.</p>

    <br>
    <p>Thanks,<br>Laravel Team</p>
</body>
</html>
