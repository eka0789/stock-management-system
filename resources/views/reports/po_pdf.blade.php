<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding:4px; }
    </style>
</head>
<body>

<h3>Laporan Pembelian (Purchase Order)</h3>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>No PO</th>
            <th>Supplier</th>
            <th>Total Item</th>
            <th>Total Received</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $p)
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

</body>
</html>
