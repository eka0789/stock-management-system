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

<h3>Laporan Penggunaan Bahan</h3>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Item</th>
            <th>Qty</th>
            <th>Tipe</th>
            <th>User</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $m)
        <tr>
            <td>{{ $m->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $m->item->name }}</td>
            <td>{{ $m->quantity }}</td>
            <td>{{ strtoupper($m->type) }}</td>
            <td>{{ $m->user->name ?? '-' }}</td>
            <td>{{ $m->note }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
