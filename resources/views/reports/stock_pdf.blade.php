<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse;}
        th, td { border: 1px solid #000; padding:4px; }
    </style>
</head>
<body>

<h3>Laporan Stok Barang</h3>

<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>SKU</th>
            <th>Stok</th>
            <th>Min</th>
            <th>Unit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $i)
        <tr>
            <td>{{ $i->name }}</td>
            <td>{{ $i->sku }}</td>
            <td>{{ optional($i->stock)->quantity ?? 0 }}</td>
            <td>{{ $i->min_stock }}</td>
            <td>{{ $i->unit }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
