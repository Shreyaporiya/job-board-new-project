@extends('admin.layouts.app')

@section('content')
<div class="settings-wrapper">

    <h2 class="settings-title">⚙️ Display & Admin Settings</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <!-- Admin Details -->
        <div class="settings-card">
            <h4>👑 Admin Information</h4>

            <div class="input-group">
                <label>Admin Name</label>
                <input type="text" name="name" value="{{ $admin->name }}">
            </div>

            <div class="input-group">
                <label>Admin Email</label>
                <input type="email" name="email" value="{{ $admin->email }}">
            </div>

            <div class="info-row">
                <span>Role:</span>
                <span class="badge">{{ ucfirst($admin->role) }}</span>
            </div>
        </div>


        <!-- General Details (Read Only Example) -->
        <div class="settings-card">
            <h4>🌐 General System Info</h4>

            <div class="info-row">
                <span>Total Users</span>
                <strong>{{ \App\Models\User::count() }}</strong>
            </div>

            <div class="info-row">
                <span>Premium Users</span>
                <strong>{{ \App\Models\User::where('role','premium')->count() }}</strong>
            </div>

            <div class="info-row">
                <span>Free Users</span>
                <strong>{{ \App\Models\User::where('role','free')->count() }}</strong>
            </div>
        </div>

        <button type="submit" class="save-btn">💾 Save Changes</button>
    </form>

</div>

<script>
    document.getElementById('faviconTrigger')?.addEventListener('click', function () {
        document.getElementById('faviconInput').click();
    });

    document.getElementById('faviconInput')?.addEventListener('change', function () {
        if (this.files.length) {
            document.getElementById('faviconForm').submit();
        }
    });
</script>

@endsection
