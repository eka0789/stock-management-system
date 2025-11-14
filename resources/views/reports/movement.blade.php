@extends('layouts.app')
@section('title','Laporan Penggunaan Bahan')

@section('content')
<h3 class="fw-bold mb-3">Laporan Penggunaan Bahan</h3>

<div class="card mb-3">
    <div class="card-body">

        <form method="GET" class="row g-3">

            <div class="col-md-3">
                <label>Dari tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>

            <div class="col-md-3">
                <label>Sampai tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>

            <div class="col-md-3">
                <label>Item</label>
                <select name="item_id" class="form-control">
                    <option value="">-- Semua Item --</option>
                    @foreach($items as $i)
                        <option value="{{ $i->id }}" {{ request('item_id') == $i->id ? 'selected' : '' }}>
                            {{ $i->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>User</label>
                <select name="user_id" class="form-control">
                    <option value="">-- Semua User --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Tipe Transaksi</label>
                <select name="type" class="form-control">
                    <option value="">-- Semua --</option>
                    <option value="in" {{ request('type')=='in'?'selected':'' }}>IN (Barang Masuk)</option>
                    <option value="out" {{ request('type')=='out'?'selected':'' }}>OUT (Barang Keluar)</option>
                    <option value="adjust" {{ request('type')=='adjust'?'selected':'' }}>Adjust</option>
                </select>
            </div>

            <div class="col-md-3 align-self-end">
                <button class="btn btn-primary w-100">Filter</button>
            </div>

            <div class="col-md-3 align-self-end">
                <a href="{{ route('admin.reports.movement.pdf', request()->all()) }}"
                   class="btn btn-danger w-100">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>

            <div class="col-md-3 align-self-end">
                <a href="{{ route('admin.reports.movement.excel', request()->all()) }}"
                   class="btn btn-success w-100">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>
        </form>

    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Tipe</th>
                    <th>User</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movements as $m)
                <tr>
                    <td>{{ $m->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $m->item->name }}</td>
                    <td>{{ $m->quantity }}</td>
                    <td>{{ strtoupper($m->type) }}</td>
                    <td>{{ $m->user->name ?? '-' }}</td>
                    <td>{{ $m->note }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-3">
            {{ $movements->links() }}
        </div>
    </div>
</div>

@endsection
