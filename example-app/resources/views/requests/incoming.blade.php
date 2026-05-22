@extends('layouts.notification')

@section('content')
<h3>Incoming Friend Requests</h3>

@if($incomingRequests->count() == 0)
    <p>No incoming requests.</p>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sender</th>
            <th width="260px">Actions</th>
        </tr>
    </thead>
    <tbody>

    @foreach($incomingRequests as $req)
        <tr>
            <td>{{ $req->sender->name }}</td>
            <td>
                <a href="{{ route('request.accept', $req->id) }}" class="btn btn-success btn-sm">Accept</a>
                <a href="{{ route('request.reject', $req->id) }}" class="btn btn-warning btn-sm">Reject</a>
                <a href="{{ route('request.block', $req->id) }}" class="btn btn-danger btn-sm">Block</a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
@endsection
