<!DOCTYPE html>
<html>
<head>
    <title>Laravel Serialization Demo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; }
        h2 { color: #2c3e50; }
    </style>
</head>
<body>
    <h1>Laravel Serialization Demo (Multiple Users)</h1>

    <h2>Original Users (Collection)</h2>
    @foreach($users as $user)
        <pre>{{ print_r($user->toArray(), true) }}</pre>
    @endforeach

    <h2>Serialized Collection String</h2>
    <pre>{{ $serialized }}</pre>

    <h2>Unserialized Collection (Restored)</h2>
    @foreach($unserialized as $user)
        <pre>{{ print_r($user->toArray(), true) }}</pre>
    @endforeach

    <h2>JSON Format (All Users)</h2>
    <pre>{{ $json }}</pre>
</body>
</html>
