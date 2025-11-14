<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;

class POReportExport implements FromCollection
{
    protected $req;

    public function __construct($req)
    {
        $this->req = $req;
    }

    public function collection()
    {
        $query = PurchaseOrder::with(['items.item']);

        if ($this->req->start_date) $query->whereDate('created_at','>=',$this->req->start_date);
        if ($this->req->end_date) $query->whereDate('created_at','<=',$this->req->end_date);
        if ($this->req->supplier_name) $query->where('supplier_name','LIKE',"%{$this->req->supplier_name}%");
        if ($this->req->status) $query->where('status',$this->req->status);

        $data = $query->get();

        return $data->map(function($p){
            return [
                'Tanggal' => $p->created_at->format('Y-m-d'),
                'PO Number' => $p->po_number,
                'Supplier' => $p->supplier_name,
                'Total Item' => $p->items->count(),
                'Total Received' => $p->items->sum('qty_received'),
                'Status' => ucfirst($p->status)
            ];
        });
    }
}
