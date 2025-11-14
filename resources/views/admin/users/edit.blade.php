@extends('layouts.app')
@section('title', 'Edit User')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Edit User</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nama</label>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name', $user->name) }}" required>
            </div>

            {{-- EMAIL --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            {{-- ROLE --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin"   {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="leader"  {{ $user->role == 'leader' ? 'selected' : '' }}>Leader</option>
                    <option value="finance" {{ $user->role == 'finance' ? 'selected' : '' }}>Finance</option>
                </select>
            </div>

            {{-- DIVISION (optional untuk admin & finance) --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Divisi (khusus leader)</label>
                <select name="division_id" class="form-select">
                    <option value="">— Tidak Ada —</option>
                    @foreach($divisions as $d)
                        <option value="{{ $d->id }}"
                            {{ $user->division_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Update User
            </button>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
