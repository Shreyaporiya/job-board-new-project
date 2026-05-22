@extends('layouts.notification')

@section('content')
<h3>Sent Friend Requests</h3>

@if($outgoingRequests->count() == 0)
    <p>No outgoing requests.</p>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Receiver</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>

    @foreach($outgoingRequests as $req)
        <tr>
            <td>{{ $req->receiver->name }}</td>
            <td>
                <strong class="text-primary">{{ ucfirst($req->status) }}</strong>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
@endsection
