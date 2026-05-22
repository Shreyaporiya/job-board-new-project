@extends('layouts.notification')

@section('content')
<h3>All Users</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th width="180px">Action</th>
        </tr>
    </thead>
    <tbody>

    @foreach($users as $user)
        @if($user->id != auth()->id())
            <tr>
                <td>{{ $user->name }}</td>
                <td>
                    <a href="{{ route('send.request', $user->id) }}" class="btn btn-primary btn-sm">
                        Send Request
                    </a>
                </td>
            </tr>
        @endif
    @endforeach

    </tbody>
</table>
@endsection
