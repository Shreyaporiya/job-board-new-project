<!DOCTYPE html>
<html>
<head>
    <title>HTTP Client - GET Request</title>
</head>
<body>
    <h2>Posts Fetched from API</h2>
    <ul>
        @foreach($posts as $post)
            <li><strong>{{ $post['title'] }}</strong><br>{{ $post['body'] }}</li>
        @endforeach
    </ul>
</body>
</html>
