@extends('layouts.app')

@section('title','Purchase Order')

@section('content')
<h3 class="fw-bold mb-3">Purchase Order</h3>

<a href="{{ route('finance.po.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Buat PO Baru
</a>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>PO Number</th>
                    <th>Request</th>
                    <th>Status</th>
                    <th>Supplier</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($po as $p)
                <tr>
                    <td>{{ $p->po_number }}</td>
                    <td>{{ $p->request->code ?? '-' }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td>{{ $p->supplier_name ?? '-' }}</td>
                    <td><a href="{{ route('finance.po.show',$p->id) }}" class="btn btn-info btn-sm">Detail</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
