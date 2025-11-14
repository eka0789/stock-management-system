@extends('layouts.app')
@section('title','Buat Permintaan Bahan')

@section('content')

<h3 class="fw-bold mb-3">Buat Permintaan Bahan</h3>

<form method="POST" action="{{ route('leader.requests.store') }}">
    @csrf

    <div id="items-container">

        <div class="row g-3 mb-3 item-row">
            <div class="col-md-6">
                <label>Item</label>
                <select name="items[0][item_id]" class="form-control">
                    @foreach($items as $i)
                        <option value="{{ $i->id }}">{{ $i->name }} ({{ $i->unit }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Jumlah</label>
                <input type="number" step="0.1" name="items[0][qty]" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item w-100">Hapus</button>
            </div>
        </div>

    </div>

    <button id="add-item" type="button" class="btn btn-secondary mb-3">
        <i class="fas fa-plus"></i> Tambah Item
    </button>

    <textarea name="note" class="form-control mb-3" placeholder="Catatan (opsional)"></textarea>

    <button class="btn btn-primary">Kirim Permintaan</button>
</form>

<script>
document.getElementById('add-item').addEventListener('click', function () {
    let container = document.getElementById('items-container');
    let index = container.children.length;

    let template = `
    <div class="row g-3 mb-3 item-row">
        <div class="col-md-6">
            <label>Item</label>
            <select name="items[${index}][item_id]" class="form-control">
                @foreach($items as $i)
                    <option value="{{ $i->id }}">{{ $i->name }} ({{ $i->unit }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Jumlah</label>
            <input type="number" step="0.1" name="items[${index}][qty]" class="form-control">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-item w-100">Hapus</button>
        </div>
    </div>`;

    container.insertAdjacentHTML('beforeend', template);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-item')) {
        e.target.closest('.item-row').remove();
    }
});
</script>

@endsection

