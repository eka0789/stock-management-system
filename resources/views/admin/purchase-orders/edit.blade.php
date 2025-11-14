@extends('layouts.app')
@section('title', 'Edit Purchase Order')

@section('content')

<h3 class="fw-bold mb-4">Edit Purchase Order</h3>

<form action="{{ route('admin.purchase-orders.update', $purchaseOrder->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label fw-bold">Supplier</label>
                <input type="text" name="supplier_name" class="form-control" 
                       value="{{ $purchaseOrder->supplier_name }}" required>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Item PO</h5>

            <table class="table" id="itemTable">
                <thead class="table-light">
                    <tr>
                        <th>Barang</th>
                        <th width="120">Qty</th>
                        <th width="150">Harga</th>
                        <th width="50"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($purchaseOrder->items as $item)
                    <tr>
                        <td>
                            <select name="item_id[]" class="form-control" required>
                                @foreach ($items as $i)
                                    <option value="{{ $i->id }}" 
                                        {{ $item->item_id == $i->id ? 'selected' : '' }}>
                                        {{ $i->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td><input type="number" name="quantity[]" class="form-control" 
                                   value="{{ $item->quantity }}" required></td>

                        <td><input type="number" name="price[]" class="form-control" 
                                   value="{{ $item->price }}" required></td>

                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRow">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" id="addRow" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Tambah Baris
            </button>

        </div>
    </div>

    <button type="submit" class="btn btn-primary px-4">Update PO</button>

</form>


<script>
document.getElementById('addRow').addEventListener('click', function() {
    let table = document.querySelector('#itemTable tbody');
    let row = `
        <tr>
            <td>
                <select name="item_id[]" class="form-control" required>
                    @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="quantity[]" class="form-control" required></td>
            <td><input type="number" name="price[]" class="form-control" required></td>
            <td>
                <button type="button" class="btn btn-danger btn-sm removeRow">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    table.insertAdjacentHTML('beforeend', row);
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>

@endsection
