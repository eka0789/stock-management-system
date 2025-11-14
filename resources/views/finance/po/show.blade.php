@extends('layouts.app')
@section('title','Detail PO')

@section('content')

<h3 class="fw-bold mb-3">Detail PO - {{ $po->po_number }}</h3>

<div class="mb-3">
    <strong>Supplier:</strong> {{ $po->supplier_name }} <br>
    <strong>Status:</strong> {{ ucfirst($po->status) }}
</div>

<h5>Item dalam PO</h5>

<form method="POST" action="{{ route('finance.po.receive', $po->id) }}">
    @csrf

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Ordered</th>
                <th>Received</th>
                <th>Receive Now</th>
            </tr>
        </thead>
        <tbody>
            @foreach($po->items as $i)
            <tr>
                <td>{{ $i->item->name }}</td>
                <td>{{ $i->qty_ordered }}</td>
                <td>{{ $i->qty_received }}</td>
                <td>
                    <input type="number" step="0.1" name="qty_received[{{ $i->id }}]" class="form-control" value="0">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button class="btn btn-success">Receive</button>
</form>

@endsection
