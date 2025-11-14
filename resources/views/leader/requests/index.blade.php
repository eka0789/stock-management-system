@extends('layouts.app')

@section('title','Permintaan Bahan')

@section('content')
<h3 class="fw-bold mb-3">Permintaan Bahan</h3>

<a href="{{ route('leader.requests.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Buat Permintaan
</a>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $r)
                <tr>
                    <td>{{ $r->code }}</td>
                    <td>{{ ucfirst($r->status) }}</td>
                    <td>{{ $r->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('leader.requests.show',$r->id) }}" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
