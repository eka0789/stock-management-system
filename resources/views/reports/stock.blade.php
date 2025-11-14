@extends('layouts.app')
@section('title','Laporan Stok')

@section('content')
<h3 class="fw-bold mb-3">Laporan Stok</h3>

<a href="{{ route('admin.reports.stock.pdf') }}" class="btn btn-danger mb-3">
    <i class="fas fa-file-pdf"></i> Export PDF
</a>

<a href="{{ route('admin.reports.stock.excel') }}" class="btn btn-success mb-3">
    <i class="fas fa-file-excel"></i> Export Excel
</a>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Item</th>
                    <th>SKU</th>
                    <th>Stok</th>
                    <th>Min</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $i)
                <tr>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->sku }}</td>
                    <td>{{ optional($i->stock)->quantity ?? 0 }}</td>
                    <td>{{ $i->min_stock }}</td>
                    <td>{{ $i->unit }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
