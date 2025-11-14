@extends('layouts.app')
@section('title', 'Detail Purchase Order')

@section('content')

<h3 class="fw-bold mb-4">Detail Purchase Order</h3>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">

        <h5 class="fw-bold">Informasi PO</h5>
        <p><strong>No PO:</strong> {{ $purchaseOrder->po_number }}</p>
        <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier_name }}</p>
        <p><strong>Total Harga:</strong> Rp {{ number_format($purchaseOrder->total_price,0,',','.') }}</p>

        <p><strong>Status: </strong>
            <span class="badge bg-{{ 
                $purchaseOrder->status === 'received' ? 'success' : 
                ($purchaseOrder->status === 'pending' ? 'warning' : 'secondary')
            }}">
                {{ ucfirst($purchaseOrder->status) }}
            </span>
        </p>

    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">

        <h5 class="fw-bold mb-3">Daftar Item</h5>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Barang</th>
                    <th width="100">Qty</th>
                    <th width="150">Harga</th>
                    <th width="150">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($purchaseOrder->items as $item)
                    <tr>
                        <td>{{ $item->item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price,0,',','.') }}</td>
                        <td>Rp {{ number_format($item->quantity * $item->price,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>


{{-- Tombol Aksi --}}
<a href="{{ route('admin.purchase-orders.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

@if ($purchaseOrder->status !== 'received')
<form action="{{ route('admin.purchase-orders.receive', $purchaseOrder->id) }}"
      method="POST" class="d-inline">
    @csrf
    <button class="btn btn-success">
        <i class="fas fa-check"></i> Terima Barang
    </button>
</form>
@endif

@endsection
