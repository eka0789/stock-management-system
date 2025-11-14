<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockReportExport implements FromCollection
{
    public function collection()
    {
        return Item::with('stock')->get()->map(function($item){
            return [
                'Item' => $item->name,
                'SKU' => $item->sku,
                'Stok' => optional($item->stock)->quantity ?? 0,
                'Min Stock' => $item->min_stock,
                'Unit' => $item->unit
            ];
        });
    }
}
