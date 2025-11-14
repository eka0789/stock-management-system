@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')

<h3 class="mb-4 fw-bold">Dashboard Admin</h3>


{{-- ======================= MENU QUICK ACTION ======================= --}}
<div class="row g-4">

    <div class="col-md-3">
        <a href="{{ route('admin.items.index') }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-3 hover-card h-100">
                <div class="card-body text-center py-4">
                    <i class="fas fa-box fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Manajemen Items</h5>
                    <p class="text-muted small">Tambah atau ubah data barang.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('admin.requests.index') }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-3 hover-card h-100">
                <div class="card-body text-center py-4">
                    <i class="fas fa-file-alt fa-3x text-info mb-3"></i>
                    <h5 class="fw-bold">Permintaan Barang</h5>
                    <p class="text-muted small">Kelola permintaan barang.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('admin.purchase-orders.index') }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-3 hover-card h-100">
                <div class="card-body text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Purchase Orders</h5>
                    <p class="text-muted small">Kelola PO & barang masuk.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-3 hover-card h-100">
                <div class="card-body text-center py-4">
                    <i class="fas fa-users fa-3x text-secondary mb-3"></i>
                    <h5 class="fw-bold">User Management</h5>
                    <p class="text-muted small">Kelola user & role divisi.</p>
                </div>
            </div>
        </a>
    </div>

</div>



{{-- ======================= TABEL AKTIVITAS TERBARU ======================= --}}
<h4 class="mt-5 mb-3 fw-bold">Aktivitas Permintaan Terbaru</h4>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">

        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Pemohon</th>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
@forelse ($latestRequests as $req)
    <tr>
        <td>{{ $req->id }}</td>

        {{-- Pemohon --}}
        <td>{{ $req->requester->name ?? '-' }}</td>

        {{-- Item (pertama) --}}
        <td>
            @if ($req->items->count() == 1)
                {{ $req->items->first()->item->name }}
            @elseif ($req->items->count() > 1)
                {{ $req->items->first()->item->name }} + {{ $req->items->count() - 1 }} lainnya
            @else
                -
            @endif
        </td>

        {{-- Quantity total --}}
        <td>{{ $req->items->sum('quantity') }}</td>

        {{-- Status --}}
        <td>
            <span class="badge bg-{{ $req->status == 'approved' ? 'success' : ($req->status == 'pending' ? 'warning' : 'danger') }}">
                {{ ucfirst($req->status) }}
            </span>
        </td>

        {{-- Tanggal --}}
        <td>{{ $req->created_at->format('d M Y') }}</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-3 text-muted">
            Belum ada aktivitas permintaan.
        </td>
    </tr>
@endforelse
</tbody>

        </table>

    </div>
</div>


{{-- ===== STYLE kecil biar card-nya lebih interaktif ===== --}}
<style>
.hover-card { transition: 0.2s; }
.hover-card:hover { transform: translateY(-5px); }
</style>

@endsection
