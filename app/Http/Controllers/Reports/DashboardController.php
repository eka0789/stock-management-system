<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\StockItem;
use App\Models\StockTransaction;
use App\Models\PurchaseOrder;
use App\Models\Request as RequestModel;
use App\Models\Division;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Cards
        $totalItems = Item::count();
        $totalStock = StockItem::sum('quantity');
        $pendingRequests = RequestModel::where('status','pending')->count();

        $poThisMonth = PurchaseOrder::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count();

        // ========== Chart 1: Low Stock ==========
        $lowStock = Item::with('stock')
            ->get()
            ->filter(fn($i) => optional($i->stock)->quantity <= $i->min_stock)
            ->take(10)
            ->map(fn($i)=>[
                'name' => $i->name,
                'quantity' => optional($i->stock)->quantity ?? 0
            ])
            ->values();

        // ========== Chart 2: Weekly Usage ==========
        $weeklyUsage = StockTransaction::select(
                DB::raw("DATE(created_at) as date"),
                DB::raw("SUM(quantity) as total")
            )
            ->where('type', 'out')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ========== Chart 3: PO Monthly ==========
        $poMonthly = PurchaseOrder::select(
                DB::raw("MONTH(created_at) as month"),
                DB::raw("COUNT(*) as total")
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ========== Chart 4: Request per Division ==========
        $reqPerDiv = Division::withCount('requests')->get();

        return view('reports.dashboard', compact(
            'totalItems','totalStock','pendingRequests','poThisMonth',
            'lowStock','weeklyUsage','poMonthly','reqPerDiv'
        ));
    }
}
