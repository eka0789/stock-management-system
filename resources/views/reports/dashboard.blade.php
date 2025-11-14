@extends('layouts.app')
@section('title', 'Dashboard Statistik')

@section('content')

<h3 class="fw-bold mb-4">Dashboard Statistik</h3>

{{-- ======================== CARDS ======================== --}}
<div class="row">

    <div class="col-md-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $totalItems }}</h3>
                <p>Total Item</p>
            </div>
            <div class="icon"><i class="fas fa-boxes"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalStock }}</h3>
                <p>Total Stok</p>
            </div>
            <div class="icon"><i class="fas fa-database"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendingRequests }}</h3>
                <p>Request Pending</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $poThisMonth }}</h3>
                <p>PO Bulan Ini</p>
            </div>
            <div class="icon"><i class="fas fa-file-invoice"></i></div>
        </div>
    </div>

</div>

{{-- ======================== CHARTS ======================== --}}
<div class="row">

    {{-- CHART 1: Low Stock --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Stok Rendah</div>
            <div class="card-body">
                <canvas id="chartLowStock"></canvas>
            </div>
        </div>
    </div>

    {{-- CHART 2: Weekly Usage --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">Pemakaian Bahan 7 Hari</div>
            <div class="card-body">
                <canvas id="chartWeeklyUsage"></canvas>
            </div>
        </div>
    </div>

</div>

<div class="row">

    {{-- CHART 3: PO Monthly --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-danger text-white">PO Bulanan</div>
            <div class="card-body">
                <canvas id="chartPOMonthly"></canvas>
            </div>
        </div>
    </div>

    {{-- CHART 4: Request per Division --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-white">Permintaan per Divisi</div>
            <div class="card-body">
                <canvas id="chartReqDiv"></canvas>
            </div>
        </div>
    </div>

</div>





{{-- ======================== CHART.JS SCRIPT ======================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ========== Low Stock ==========
    const lowStockData = {
        labels: {!! $lowStock->pluck('name') !!},
        datasets: [{
            label: 'Stok',
            data: {!! $lowStock->pluck('quantity') !!},
            backgroundColor: 'rgba(255, 99, 132, 0.7)'
        }]
    };
    new Chart(document.getElementById('chartLowStock'), {
        type: 'bar',
        data: lowStockData
    });

    // ========== Weekly Usage ==========
    const usageData = {
        labels: {!! $weeklyUsage->pluck('date') !!},
        datasets: [{
            label: 'Pemakaian',
            data: {!! $weeklyUsage->pluck('total') !!},
            borderColor: 'rgba(54, 162, 235, 0.9)',
            fill: false,
            tension: .3
        }]
    };
    new Chart(document.getElementById('chartWeeklyUsage'), {
        type: 'line',
        data: usageData
    });

    // ========== PO Monthly ==========
    const poData = {
        labels: {!! $poMonthly->pluck('month') !!},
        datasets: [{
            label: 'Total PO',
            data: {!! $poMonthly->pluck('total') !!},
            backgroundColor: 'rgba(255, 206, 86, 0.8)'
        }]
    };
    new Chart(document.getElementById('chartPOMonthly'), {
        type: 'bar',
        data: poData
    });

    // ========== Requests per Division ==========
    const reqDivData = {
        labels: {!! $reqPerDiv->pluck('name') !!},
        datasets: [{
            label: 'Request',
            data: {!! $reqPerDiv->pluck('requests_count') !!},
            backgroundColor: [
                'rgba(255, 159, 64, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(201, 203, 207, 0.8)'
            ]
        }]
    };
    new Chart(document.getElementById('chartReqDiv'), {
        type: 'pie',
        data: reqDivData
    });

</script>

@endsection
