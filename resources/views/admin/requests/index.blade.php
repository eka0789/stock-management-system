@extends('layouts.app')
@section('title','Permintaan Pending')

@section('content')

<h3 class="fw-bold mb-3">Permintaan Menunggu Persetujuan</h3>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Leader</th>
                    <th>Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $r)
                <tr>
                    <td>{{ $r->code }}</td>
                    <td>{{ $r->requester->name }}</td>
                    <td>{{ $r->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.requests.edit',$r->id) }}" class="btn btn-info btn-sm">Proses</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
