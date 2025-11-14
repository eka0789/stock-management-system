@extends('layouts.app')
@section('title','Notifications')

@section('content')
<h3 class="fw-bold mb-3">Notifications</h3>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('notifications.read') }}">
            @csrf
            <button class="btn btn-sm btn-outline-primary mb-3">Mark all as read</button>
        </form>

        <ul class="list-group">
            @foreach($notifications as $n)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-semibold">{{ $n->data['message'] ?? 'Notification' }}</div>
                    <div class="small text-muted">{{ $n->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <div>
                    @if(is_null($n->read_at))
                        <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-primary">Mark read</button>
                        </form>
                    @else
                        <span class="badge bg-success">Read</span>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
