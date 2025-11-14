<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:4px; }
    </style>
</head>
<body>

<h3>Laporan Permintaan Bahan</h3>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kode Request</th>
            <th>Leader</th>
            <th>Divisi</th>
            <th>Jumlah Item</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $r)
        <tr>
            <td>{{ $r->created_at->format('Y-m-d') }}</td>
            <td>{{ $r->code }}</td>
            <td>{{ $r->requester->name }}</td>
            <td>{{ $r->requester->division->name ?? '-' }}</td>
            <td>{{ $r->items->count() }}</td>
            <td>{{ ucfirst($r->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
