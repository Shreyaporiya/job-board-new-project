<!DOCTYPE html>
<html>
<head>
    <title>Download File Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Laravel File Download Example</h2>
    <p>Click the button below to download the PDF file.</p>

    <a href="{{ route('download.file') }}" class="btn btn-primary">
        Download PDF
    </a>

</body>
</html>
