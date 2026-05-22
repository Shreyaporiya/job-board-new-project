<!DOCTYPE html>
<html>
<head>
    <title>HTTP Client - POST Request</title>
</head>
<body>
    <h2>Post Created Successfully</h2>
    <p><strong>Title:</strong> {{ $post['title'] }}</p>
    <p><strong>Body:</strong> {{ $post['body'] }}</p>
    <p><strong>User ID:</strong> {{ $post['userId'] }}</p>
    <p><strong>ID (from API):</strong> {{ $post['id'] ?? 'N/A' }}</p>
</body>
</html>
