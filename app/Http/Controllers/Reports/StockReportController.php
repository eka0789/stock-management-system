<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Item;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockReportExport;

class StockReportController extends Controller
{
    public function index()
    {
        $items = Item::with('stock')->orderBy('name')->get();
        return view('reports.stock', compact('items'));
    }

    public function exportPdf()
    {
        $items = Item::with('stock')->orderBy('name')->get();
        $pdf = PDF::loadView('reports.stock_pdf', compact('items'));
        return $pdf->download('laporan_stok.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new StockReportExport, 'laporan_stok.xlsx');
    }
}
