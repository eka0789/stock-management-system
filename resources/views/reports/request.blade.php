@extends('layouts.app')
@section('title','Laporan Permintaan Bahan')

@section('content')
<h3 class="fw-bold mb-3">Laporan Permintaan Bahan</h3>

<div class="card mb-3">
    <div class="card-body">

        <form method="GET" class="row g-3">

            <div class="col-md-3">
                <label>Mulai Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>

            <div class="col-md-3">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>

            <div class="col-md-3">
                <label>Divisi</label>
                <select name="division_id" class="form-control">
                    <option value="">-- Semua Divisi --</option>
                    @foreach($divisions as $d)
                        <option value="{{ $d->id }}" {{ request('division_id')==$d->id?'selected':'' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Leader</label>
                <select name="user_id" class="form-control">
                    <option value="">-- Semua Leader --</option>
                    @foreach($leaders as $l)
                        <option value="{{ $l->id }}" {{ request('user_id')==$l->id?'selected':'' }}>
                            {{ $l->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">-- Semua --</option>
                    @foreach(['pending','approved','rejected','forwarded','completed'] as $s)
                        <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Item</label>
                <select name="item_id" class="form-control">
                    <option value="">-- Semua Item --</option>
                    @foreach($items as $i)
                        <option value="{{ $i->id }}" {{ request('item_id')==$i->id?'selected':'' }}>
                            {{ $i->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">Filter</button>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('admin.reports.request.pdf', request()->all()) }}" 
                   class="btn btn-danger w-100">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('admin.reports.request.excel', request()->all()) }}" 
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
                    <th>Kode</th>
                    <th>Leader</th>
                    <th>Divisi</th>
                    <th>Jumlah Item</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($requests as $r)
                <tr>
                    <td>{{ $r->created_at->format('Y-m-d') }}</td>
                    <td>{{ $r->code }}</td>
                    <td>{{ $r->requester->name }}</td>
                    <td>{{ $r->requester->division->name ?? '-' }}</td>
                    <td>{{ $r->items->count() }}</td>

                    {{-- ================= BADGE STATUS ================= --}}
                    <td>
                        @switch($r->status)

                            @case('pending')
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock me-1"></i> Pending
                                </span>
                                @break

                            @case('approved')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Approved
                                </span>
                                @break

                            @case('rejected')
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i> Rejected
                                </span>
                                @break

                            @case('forwarded')
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-share-square me-1"></i> Forwarded
                                </span>
                                @break

                            @case('completed')
                                <span class="badge bg-primary">
                                    <i class="fas fa-check-double me-1"></i> Completed
                                </span>
                                @break

                            @default
                                <span class="badge bg-secondary">{{ ucfirst($r->status) }}</span>

                        @endswitch
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-3">
            {{ $requests->links() }}
        </div>

    </div>
</div>

@endsection
