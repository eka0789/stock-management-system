@extends('layouts.app')
@section('title','Buat Purchase Order')

@section('content')
<h3 class="fw-bold mb-3">Buat Purchase Order</h3>

<form method="POST" action="{{ route('finance.po.store') }}">
    @csrf

    <div class="mb-3">
        <label>Request</label>
        <select name="request_id" class="form-control">
            @foreach($requests as $r)
            <option value="{{ $r->id }}">{{ $r->code }} - {{ $r->requester->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label>Supplier Name</label>
            <input name="supplier_name" class="form-control">
        </div>
        <div class="col-md-4">
            <label>Contact</label>
            <input name="supplier_contact" class="form-control">
        </div>
        <div class="col-md-4">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control">
        </div>
    </div>

    <button class="btn btn-primary mt-3">Buat PO</button>

</form>
@endsection
