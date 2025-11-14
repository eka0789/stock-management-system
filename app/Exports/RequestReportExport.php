<?php

namespace App\Exports;

use App\Models\Request as RequestModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class RequestReportExport implements FromCollection
{
    protected $req;

    public function __construct($req)
    {
        $this->req = $req;
    }

    public function collection()
    {
        $query = RequestModel::with(['requester.division','items.item']);

        if ($this->req->start_date) $query->whereDate('created_at','>=',$this->req->start_date);
        if ($this->req->end_date) $query->whereDate('created_at','<=',$this->req->end_date);
        if ($this->req->division_id) {
            $query->whereHas('requester', fn($q)=>$q->where('division_id',$this->req->division_id));
        }
        if ($this->req->user_id) $query->where('user_id',$this->req->user_id);
        if ($this->req->status) $query->where('status',$this->req->status);

        $data = $query->get();

        return $data->map(function($r){
            return [
                'Tanggal' => $r->created_at->format('Y-m-d H:i'),
                'Kode Request' => $r->code,
                'Leader' => $r->requester->name ?? '-',
                'Divisi' => $r->requester->division->name ?? '-',
                'Total Item' => $r->items->count(),
                'Status' => ucfirst($r->status),
            ];
        });
    }
}
