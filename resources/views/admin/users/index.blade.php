@extends('layouts.app')
@section('title','Manajemen User')

@section('content')

<h3 class="fw-bold mb-4">Manajemen User</h3>

<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah User
</a>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Divisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td class="text-capitalize">{{ $u->role }}</td>
                    <td>{{ $u->division->name ?? '-' }}</td>
                    <td>

                        {{-- Edit --}}
                        <a href="{{ route('admin.users.edit',$u->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('admin.users.destroy', $u->id) }}" 
                              method="POST"
                              class="d-inline delete-form">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-danger btn-sm btn-delete">
                               Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
