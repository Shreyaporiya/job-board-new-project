<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Library Report</h2>
    <p>From: {{ $start }} — To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Book Title</th>
                <th>Issued To</th>
                <th>Issue Date</th>
                <th>Return Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($issuedBooks as $index => $book)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $book->book_title }}</td>
                <td>{{ $book->issued_to }}</td>
                <td>{{ $book->issue_date }}</td>
                <td>{{ $book->return_date ?? 'Not Returned' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
