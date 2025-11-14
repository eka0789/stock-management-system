@extends('layouts.app')
@section('title','Laporan Pembelian (PO)')

@section('content')

<h3 class="fw-bold mb-3">Laporan Pembelian</h3>

<div class="card mb-3">
    <div class="card-body">

        <form class="row g-3" method="GET">

            <div class="col-md-3">
                <label>Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Supplier</label>
                <input type="text" name="supplier_name" class="form-control" value="{{ request('supplier_name') }}">
            </div>

            <div class="col-md-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">-- Semua --</option>
                    @foreach(['draft','sent','received','completed'] as $s)
                        <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">Filter</button>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('admin.reports.po.pdf', request()->all()) }}"
                   class="btn btn-danger w-100">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('admin.reports.po.excel', request()->all()) }}"
                   class="btn btn-success w-100">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>

        </form>

    </div>
</div>


<div class="card">
    <div class="card-body p-0">

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>PO</th>
                    <th>Supplier</th>
                    <th>Total Item</th>
                    <th>Total Received</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pos as $p)
                <tr>
                    <td>{{ $p->created_at->format('Y-m-d') }}</td>
                    <td>{{ $p->po_number }}</td>
                    <td>{{ $p->supplier_name }}</td>
                    <td>{{ $p->items->count() }}</td>
                    <td>{{ $p->items->sum('qty_received') }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <div class="p-3">
            {{ $pos->links() }}
        </div>
    </div>
</div>

@endsection
