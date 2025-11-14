@extends('layouts.app')
@section('title','Riwayat Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Riwayat Stok</h3>
    <a href="{{ route('admin.stock_transactions.create_manual') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Manual Transaksi
    </a>
</div>

<div class="card shadow">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Item</th>
                    <th>Tipe</th>
                    <th>QTY</th>
                    <th>User</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr>
                    <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $t->item->name }}</td>
                    <td>{{ $t->type }}</td>
                    <td>{{ number_format($t->qty,4) }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td>{{ $t->note }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
