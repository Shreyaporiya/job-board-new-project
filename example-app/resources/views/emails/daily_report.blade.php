<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daily Report</title>
</head>
<body>
    <h2>📅 Daily Report - {{ now()->format('d M Y') }}</h2>

    <p>Hello Admin,</p>

    <p>Here is your daily summary:</p>

    <ul>
        <li>Total Users: {{ $reportData['users'] }}</li>
        <li>Total Orders: {{ $reportData['orders'] }}</li>
        <li>Revenue: ₹{{ $reportData['revenue'] }}</li>
    </ul>

    <p>Generated automatically by Laravel Scheduler ✅</p>
</body>
</html>
