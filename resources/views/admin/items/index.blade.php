@extends('layouts.app')
@section('title','Data Bahan Baku')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Data Bahan Baku</h3>
    <a href="{{ route('admin.items.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Item
    </a>
</div>

{{-- Global Alerts --}}
@include('partials.alerts')

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">

        <table class="table table-hover mb-0 align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width:110px">SKU</th>
                    <th>Nama</th>
                    <th style="width:90px">Unit</th>
                    <th style="width:120px">Stok</th>
                    <th style="width:120px">Min Stock</th>
                    <th style="width:170px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->sku ?? '-' }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->unit ?? '-' }}</td>

                    {{-- STOCK --}}
                    <td>
                        <strong>{{ number_format($item->stock->quantity ?? 0, 4) }}</strong>

                        @if(optional($item->stock)->quantity <= $item->min_stock && $item->min_stock > 0)
                            <span class="badge bg-danger ms-2">Low</span>
                        @endif
                    </td>

                    <td>{{ $item->min_stock }}</td>

                    <td>

                        {{-- Detail --}}
                        <a href="{{ route('admin.items.show', $item->id) }}" 
                           class="btn btn-info btn-sm">
                           <i class="fas fa-eye"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('admin.items.edit', $item->id) }}" 
                           class="btn btn-warning btn-sm">
                           <i class="fas fa-edit"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('admin.items.destroy', $item->id) }}" 
                              method="POST" 
                              class="d-inline delete-form">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fas fa-box-open fa-2x mb-2"></i><br>
                        Belum ada data item.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- Pagination --}}
    <div class="card-footer bg-white">
        {{ $items->links() }}
    </div>
</div>

@endsection
