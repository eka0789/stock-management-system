@extends('layouts.app')
@section('title','Manual Transaksi Stok')

@section('content')
<h3 class="fw-bold mb-3">Buat Manual Transaksi Stok</h3>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.stock_transactions.store_manual') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Item</label>
                    <select name="item_id" class="form-control" required>
                        <option value="">Pilih item</option>
                        @foreach($items as $i)
                            <option value="{{ $i->id }}">{{ $i->name }} ({{ $i->unit }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tipe</label>
                    <select name="type" class="form-control" required>
                        <option value="IN">IN (masuk)</option>
                        <option value="OUT">OUT (keluar)</option>
                        <option value="ADJUST">ADJUST</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">QTY</label>
                    <input name="qty" type="number" step="0.0001" class="form-control" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Note</label>
                    <textarea name="note" class="form-control"></textarea>
                </div>
            </div>

            <button class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</div>
@endsection
