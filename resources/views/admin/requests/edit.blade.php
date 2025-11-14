@extends('layouts.app')
@section('title','Review Permintaan')

@section('content')

<h3 class="fw-bold mb-3">Review Permintaan - {{ $req->code }}</h3>

<div class="mb-3">
    <strong>Leader:</strong> {{ $req->requester->name }} <br>
    <strong>Status:</strong> {{ ucfirst($req->status) }} <br>
</div>

<form method="POST" action="{{ route('admin.requests.approve', $req->id) }}">
    @csrf

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Diminta</th>
                <th>Disetujui</th>
            </tr>
        </thead>
        <tbody>
            @foreach($req->items as $i)
            <tr>
                <td>{{ $i->item->name }}</td>
                <td>{{ $i->qty_requested }}</td>
                <td>
                    <input type="number" step="0.1" name="qty_approved[{{ $i->id }}]" value="{{ $i->qty_requested }}" class="form-control">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button class="btn btn-success">Setujui</button>
</form>

<form class="d-inline" method="POST" action="{{ route('admin.requests.reject',$req->id) }}">
    @csrf
    <button class="btn btn-danger mt-2">Tolak</button>
</form>

<form class="d-inline" method="POST" action="{{ route('admin.requests.forward',$req->id) }}">
    @csrf
    <button class="btn btn-warning mt-2">Teruskan ke Finance</button>
</form>

@endsection

