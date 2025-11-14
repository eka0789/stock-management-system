<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use App\Models\Item;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    protected $stock;

    public function __construct(StockService $stock)
    {
        $this->stock = $stock;
    }

    public function index()
    {
        $tx = StockTransaction::with('item','user')->latest()->paginate(30);
        return view('admin.stock_transactions.index', ['transactions' => $tx]);
    }

    // Form to manual adjust stock (IN/OUT)
    public function createManual()
    {
        $items = Item::orderBy('name')->get();
        return view('admin.stock_transactions.create_manual', compact('items'));
    }

    public function storeManual(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:IN,OUT,ADJUST',
            'qty' => 'required|numeric|min:0.0001',
            'note' => 'nullable|string',
        ]);

        $userId = auth()->id();

        $meta = [
            'ref_type' => 'manual',
            'ref_id' => null,
            'user_id' => $userId,
            'note' => $data['note'] ?? null,
        ];

        if ($data['type'] === 'IN') {
            $this->stock->increase($data['item_id'], (float)$data['qty'], $meta);
        } elseif ($data['type'] === 'OUT') {
            $this->stock->decrease($data['item_id'], (float)$data['qty'], $meta);
        } else {
            // ADJUST positive or negative, here treat qty as signed number optionally
            $this->stock->adjust($data['item_id'], (float)$data['qty'], $meta);
        }

        return redirect()->route('admin.stock_transactions.index')->with('success','Transaksi stok dibuat');
    }
}
