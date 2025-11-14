<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\POReportExport;

class POReportController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['items.item'])
            ->orderBy('created_at','desc');

        // Filter tanggal PO dibuat
        if ($request->start_date) {
            $query->whereDate('created_at','>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at','<=', $request->end_date);
        }

        // Supplier
        if ($request->supplier_name) {
            $query->where('supplier_name', 'LIKE', "%{$request->supplier_name}%");
        }

        // Status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter Item tertentu dalam PO
        if ($request->item_id) {
            $query->whereHas('items', function($q) use ($request){
                $q->where('item_id', $request->item_id);
            });
        }

        $pos = $query->paginate(20);

        // For dropdowns
        $suppliers = PurchaseOrder::select('supplier_name')
                    ->distinct()
                    ->pluck('supplier_name');

        return view('reports.po', compact('pos','suppliers'));
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $data = $this->filtered($request)->get();
        $pdf = PDF::loadView('reports.po_pdf', compact('data'));
        return $pdf->download('laporan_pembelian.pdf');
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new POReportExport($request), 'laporan_pembelian.xlsx');
    }

    private function filtered($request)
    {
        $query = PurchaseOrder::with(['items.item']);

        if ($request->start_date) $query->whereDate('created_at','>=',$request->start_date);
        if ($request->end_date) $query->whereDate('created_at','<=',$request->end_date);
        if ($request->supplier_name) $query->where('supplier_name','LIKE',"%{$request->supplier_name}%");
        if ($request->status) $query->where('status',$request->status);
        if ($request->item_id) {
            $query->whereHas('items', fn($q)=>$q->where('item_id',$request->item_id));
        }

        return $query->orderBy('created_at','desc');
    }
}
