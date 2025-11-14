@extends('layouts.app')
@section('title','Tambah User')

@section('content')

<h3 class="fw-bold mb-4">Tambah User</h3>

<div class="card shadow">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="fw-bold">Nama</label>
                    <input name="name" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Email</label>
                    <input name="email" type="email" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Role</label>
                    <select name="role" class="form-control">
                        <option value="admin">Admin</option>
                        <option value="leader">Leader</option>
                        <option value="finance">Finance</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Divisi (Leader)</label>
                    <select name="division_id" class="form-control">
                        <option value="">-</option>
                        @foreach($divisions as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <button class="btn btn-primary mt-4">Simpan</button>
        </form>

    </div>
</div>

@endsection
