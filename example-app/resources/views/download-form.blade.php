<!DOCTYPE html>
<html>
<head>
    <title>Download File by Name</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Download File by Name</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('download.file') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="filename" class="form-label">Enter file name (with extension):</label>
            <input type="text" name="filename" id="filename" class="form-control" placeholder="example.pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Download</button>
    </form>
</body>
</html>
