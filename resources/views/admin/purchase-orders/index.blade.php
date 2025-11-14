@extends('layouts.app')
@section('title', 'Purchase Orders')

@section('content')

<h3 class="mb-4 fw-bold">Purchase Orders</h3>

<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">Daftar Purchase Order</h5>
    <a href="{{ route('admin.purchase-orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah PO
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">

        <table class="table table-hover mb-0" id="poTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>No. PO</th>
                    <th>Supplier</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th width="130">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($purchaseOrders as $po)
                    <tr>
                        <td>{{ $po->id }}</td>
                        <td>{{ $po->po_number }}</td>
                        <td>{{ $po->supplier_name }}</td>
                        <td>Rp {{ number_format($po->total_price,0,',','.') }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                $po->status === 'received' ? 'success' : 
                                ($po->status === 'pending' ? 'warning' : 'secondary') 
                            }}">
                                {{ ucfirst($po->status) }}
                            </span>
                        </td>
                        <td>{{ $po->created_at->format('d M Y') }}</td>

                        <td>
                            <a href="{{ route('admin.purchase-orders.show', $po->id) }}" 
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.purchase-orders.edit', $po->id) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.purchase-orders.destroy', $po->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus PO ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center py-3 text-muted">
                            Belum ada purchase order.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>
</div>

{{-- Optional DataTables --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Uncomment jika ingin DataTables
    // new DataTable('#poTable');
});
</script>

@endsection
