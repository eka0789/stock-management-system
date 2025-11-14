<?php

namespace App\Exports;

use App\Models\StockTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class MovementReportExport implements FromCollection
{
    protected $req;

    public function __construct($req)
    {
        $this->req = $req;
    }

    public function collection()
    {
        $query = StockTransaction::with(['item','user']);

        if ($this->req->start_date) $query->whereDate('created_at', '>=', $this->req->start_date);
        if ($this->req->end_date) $query->whereDate('created_at', '<=', $this->req->end_date);
        if ($this->req->item_id) $query->where('item_id', $this->req->item_id);
        if ($this->req->user_id) $query->where('user_id', $this->req->user_id);
        if ($this->req->type) $query->where('type', $this->req->type);

        return $query->get()->map(function($t){
            return [
                'Tanggal'       => $t->created_at->format('Y-m-d H:i'),
                'Item'          => $t->item->name,
                'Qty'           => $t->quantity,
                'Tipe'          => strtoupper($t->type),
                'User'          => $t->user->name ?? '-',
                'Catatan'       => $t->note,
            ];
        });
    }
}
