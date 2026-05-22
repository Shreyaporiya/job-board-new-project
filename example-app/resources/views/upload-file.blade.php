<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>
    <h1>Upload Any File</h1>

    <!-- Upload form -->
    <form action="{{ url('/upload-file') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    <!-- Display uploaded file -->
    @isset($url)
        <h2>Uploaded File:</h2>
        <p>Filename: {{ $filename }}</p>
        <a href="{{ $url }}" target="_blank">Download/View File</a>
        @if (str_starts_with($filename, 'image') || in_array(pathinfo($filename, PATHINFO_EXTENSION), ['jpg','jpeg','png','gif','webp']))
            <br>
            <img src="{{ $url }}" alt="Uploaded File" style="max-width: 200px; margin-top: 10px;">
        @endif
    @endisset
</body>
</html>
