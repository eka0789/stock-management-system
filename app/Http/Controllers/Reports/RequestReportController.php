<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Models\Division;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RequestReportExport;

class RequestReportController extends Controller
{
    public function index(Request $request)
    {
        $query = RequestModel::with(['requester.division', 'items.item'])
            ->orderBy('created_at', 'desc');

        // Filter tanggal
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter divisi
        if ($request->division_id) {
            $query->whereHas('requester', function($q) use ($request){
                $q->where('division_id', $request->division_id);
            });
        }

        // Filter leader
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter item spesifik
        if ($request->item_id) {
            $query->whereHas('items', function($q) use ($request){
                $q->where('item_id', $request->item_id);
            });
        }

        $requests = $query->paginate(20);

        $divisions = Division::orderBy('name')->get();
        $leaders = User::where('role','leader')->orderBy('name')->get();
        $items = Item::orderBy('name')->get();

        return view('reports.request', compact('requests','divisions','leaders','items'));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->filtered($request)->get();

        $pdf = PDF::loadView('reports.request_pdf', compact('data'));
        return $pdf->download('laporan_permintaan_bahan.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new RequestReportExport($request), 'laporan_permintaan_bahan.xlsx');
    }

    private function filtered($request)
    {
        $query = RequestModel::with(['requester.division','items.item']);

        if ($request->start_date) $query->whereDate('created_at','>=',$request->start_date);
        if ($request->end_date) $query->whereDate('created_at','<=',$request->end_date);
        if ($request->division_id) {
            $query->whereHas('requester', fn($q)=>$q->where('division_id',$request->division_id));
        }
        if ($request->user_id) $query->where('user_id',$request->user_id);
        if ($request->status) $query->where('status',$request->status);
        if ($request->item_id) {
            $query->whereHas('items', fn($q)=>$q->where('item_id',request('item_id')));
        }

        return $query->orderBy('created_at','desc');
    }
}
