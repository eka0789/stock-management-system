<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use App\Models\Item;
use App\Models\User;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MovementReportExport;
use Illuminate\Http\Request;

class MovementReportController extends Controller
{
    public function index(Request $request)
    {
        $query = StockTransaction::with(['item', 'user'])
            ->orderBy('created_at', 'desc');

        // Filter tanggal
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter item
        if ($request->item_id) {
            $query->where('item_id', $request->item_id);
        }

        // Filter user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        $movements = $query->paginate(20);

        $items = Item::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('reports.movement', compact('movements', 'items', 'users'));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->filtered($request)->get();

        $pdf = PDF::loadView('reports.movement_pdf', compact('data'));
        return $pdf->download('laporan_penggunaan_bahan.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new MovementReportExport($request), 'laporan_penggunaan_bahan.xlsx');
    }

    private function filtered($request)
    {
        $query = StockTransaction::with(['item', 'user']);

        if ($request->start_date) $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->end_date) $query->whereDate('created_at', '<=', $request->end_date);
        if ($request->item_id) $query->where('item_id', $request->item_id);
        if ($request->user_id) $query->where('user_id', $request->user_id);
        if ($request->type) $query->where('type', $request->type);

        return $query->orderBy('created_at', 'desc');
    }
}
