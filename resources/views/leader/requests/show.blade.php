@extends('layouts.app')
@section('title','Detail Permintaan')

@section('content')

<h3 class="fw-bold mb-3">Detail Permintaan - {{ $req->code }}</h3>

<div class="card mb-3">
    <div class="card-body">
        <p><strong>Divisi:</strong> {{ $req->requester->division->name ?? '-' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($req->status) }}</p>
        <p><strong>Catatan:</strong> {{ $req->note ?? '-' }}</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Diminta</th>
                    <th>Disetujui Admin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($req->items as $i)
                <tr>
                    <td>{{ $i->item->name }}</td>
                    <td>{{ $i->qty_requested }}</td>
                    <td>{{ $i->qty_approved ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
