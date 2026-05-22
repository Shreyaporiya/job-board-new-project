@extends('layouts.notification')

@section('content')
<h3>Notifications</h3>

@if(auth()->user()->notifications->count() == 0)
    <p>No notifications.</p>
@endif

<ul class="list-group">

    @foreach(auth()->user()->notifications as $note)
        <li class="list-group-item">
            {{ $note->data['message'] }}
            <span class="text-muted float-end">{{ $note->created_at->diffForHumans() }}</span>
        </li>
    @endforeach

</ul>
@endsection
