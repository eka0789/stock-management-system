@extends('layouts.app')
@section('title','Detail Item')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Detail: {{ $item->name }}</h3>
    <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="mb-1">{{ $item->name }}</h5>
                <p class="mb-1"><strong>SKU:</strong> {{ $item->sku ?? '-' }}</p>
                <p class="mb-1"><strong>Unit:</strong> {{ $item->unit ?? '-' }}</p>
                <p class="mb-1"><strong>Min Stock:</strong> {{ $item->min_stock }}</p>
                <p class="mb-1"><strong>Stok Sekarang:</strong>
                    <span class="fw-bold">{{ number_format($item->stock->quantity ?? 0,4) }}</span>
                </p>
                <p class="mb-1"><strong>Harga Pokok:</strong> {{ number_format($item->cost_price,2) }}</p>
                <p class="mt-3">{{ $item->note }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="mb-3">Riwayat Transaksi</h5>

                <table class="table table-sm">
                    <thead class="table-light"><tr>
                        <th>Tanggal</th><th>Tipe</th><th>QTY</th><th>User</th><th>Note</th>
                    </tr></thead>
                    <tbody>
                        @foreach($item->transactions as $t)
                        <tr>
                            <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $t->type }}</td>
                            <td>{{ number_format($t->qty,4) }}</td>
                            <td>{{ $t->user->name ?? '-' }}</td>
                            <td>{{ $t->note }}</td>
                        </tr>
                        @endforeach
                        @if($item->transactions->isEmpty())
                        <tr><td colspan="5" class="text-center">Belum ada transaksi</td></tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
