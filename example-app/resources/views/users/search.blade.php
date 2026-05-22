<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search & Filter</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: #f5f7fa;
        }
        .card {
            border-radius: 12px;
        }
        .table thead {
            background: #007bff;
            color: white;
        }
        .table-hover tbody tr:hover {
            background: #e9f2ff;
        }
    </style>
</head>

<body>

@foreach(auth()->user()->notifications as $notification)
    <div class="alert alert-info">
        {{ $notification->data['message'] }}
    </div>
@endforeach


<div class="container py-5">

    <h2 class="mb-4 fw-bold text-center">User Search, Filter & Sort</h2>

    {{-- ====================== Search & Filter Section ====================== --}}
    <form method="GET" action="{{ route('users.search') }}" class="mb-4">
        <div class="card shadow-sm border-0 p-3">
            <div class="row g-3 align-items-end">

                {{-- Search --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search User</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search by name or email"
                               value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Select Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Sort --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <select name="sort" class="form-select">
                        <option value="">Sort By</option>
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                </div>

                {{-- Button --}}
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-filter-circle"></i> Apply
                    </button>
                </div>

            </div>
        </div>
    </form>

    {{-- ====================== Data Table Section ====================== --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="py-3">Name</th>
                        <th class="py-3">Email</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-danger py-4">
                                <i class="bi bi-x-circle"></i> No records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $users->links() }}
    </div>

</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
