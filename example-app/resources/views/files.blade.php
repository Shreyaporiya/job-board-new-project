<!DOCTYPE html>
<html>
<head>
    <title>File Upload & Management</title>
</head>
<body>
    <h1>Upload & Manage Files</h1>

    <!-- Success/Error messages -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Upload Form -->
    <form action="{{ url('/files/upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    <hr>

    <h2>Uploaded Files:</h2>
    @if(count($files) > 0)
        <ul>
            @foreach($files as $file)
                <li>
                    <a href="{{ $file['url'] }}" target="_blank">{{ $file['name'] }}</a>

                    <!-- Delete Form -->
                    <form action="{{ url('/files/delete') }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="filename" value="{{ $file['name'] }}">
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>

                    <!-- Show preview for images -->
                    @if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['jpg','jpeg','png','gif','webp']))
                        <br>
                        <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" style="max-width: 150px; margin-top: 5px;">
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>No files uploaded yet.</p>
    @endif
</body>
</html>
