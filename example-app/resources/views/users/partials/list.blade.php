@foreach ($users as $user)
    <div class="user-card">
        <strong>{{ $user->id }}</strong> - {{ $user->name }}
    </div>
@endforeach

<div id="next-cursor" data-next="{{ $users->nextCursor()?->encode() }}"></div>
