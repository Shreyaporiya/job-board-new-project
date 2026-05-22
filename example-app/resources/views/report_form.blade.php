<!DOCTYPE html>
<html>
<head>
    <title>Generate Library Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="mb-4">📘 Generate Library Report</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('report.generate') }}">
            @csrf
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Generate Report</button>
        </form>
    </div>
</div>

</body>
</html>
