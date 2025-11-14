<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <ul class="navbar-nav ms-auto me-3 align-items-center">

        {{-- Notifications dropdown --}}
        @auth
        @php
            $unreadCount = auth()->user()->unreadNotifications->count();
            $recent = auth()->user()->notifications()->limit(5)->get();
        @endphp

        <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if($unreadCount)
                    <span class="badge rounded-pill bg-danger ms-1">{{ $unreadCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end p-2" style="min-width:320px;">
                <h6 class="dropdown-header">Notifications</h6>

                @forelse($recent as $note)
                    <a href="{{ route('notifications.index') }}" class="dropdown-item d-flex">
                        <div class="flex-grow-1">
                            <div class="small text-muted">{{ $note->created_at->diffForHumans() }}</div>
                            <div class="fw-semibold">{{ $note->data['message'] ?? 'Notification' }}</div>
                        </div>
                        @if(is_null($note->read_at))
                            <span class="badge bg-primary align-self-center">New</span>
                        @endif
                    </a>
                @empty
                    <div class="px-3 py-2">No notifications</div>
                @endforelse

                <div class="dropdown-divider"></div>
                <div class="px-2">
                    <form method="POST" action="{{ route('notifications.read') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary w-100">Mark all as read</button>
                    </form>
                    <a class="btn btn-sm btn-link w-100 mt-2" href="{{ route('notifications.index') }}">View all</a>
                </div>
            </div>
        </li>
        @endauth

        <li class="nav-item">
            <a class="nav-link fw-bold text-danger" href="#">
                <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name ?? 'User' }}
            </a>
        </li>
    </ul>
</nav>
