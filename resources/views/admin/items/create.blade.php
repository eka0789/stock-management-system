@extends('layouts.app')
@section('title','Tambah Item')

@section('content')
<h3 class="fw-bold mb-3">Tambah Item</h3>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.items.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">SKU</label>
                    <input name="sku" class="form-control" value="{{ old('sku') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nama</label>
                    <input name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unit</label>
                    <input name="unit" class="form-control" value="{{ old('unit') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Min Stock</label>
                    <input name="min_stock" type="number" class="form-control" value="{{ old('min_stock',0) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga Pokok</label>
                    <input name="cost_price" type="number" step="0.01" class="form-control" value="{{ old('cost_price',0) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Initial Stock (opsional)</label>
                    <input name="initial_stock" type="number" step="0.0001" class="form-control" value="{{ old('initial_stock') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                </div>
            </div>

            <button class="btn btn-primary mt-4">Simpan</button>
        </form>
    </div>
</div>
@endsection
