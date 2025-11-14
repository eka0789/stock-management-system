<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\StockItem;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('stock')->orderBy('name')->paginate(20);
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => 'nullable|string|unique:items,sku',
            'name' => 'required|string',
            'unit' => 'nullable|string',
            'min_stock' => 'nullable|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        $item = Item::create($data);

        // optionally initialize stock
        if ($request->filled('initial_stock')) {
            StockItem::create([
                'item_id' => $item->id,
                'quantity' => (float)$request->input('initial_stock'),
            ]);
        }

        return redirect()->route('admin.items.index')->with('success','Item berhasil dibuat');
    }

    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'sku' => 'nullable|string|unique:items,sku,'.$item->id,
            'name' => 'required|string',
            'unit' => 'nullable|string',
            'min_stock' => 'nullable|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        $item->update($data);
        return redirect()->route('admin.items.index')->with('success','Item diperbarui');
    }

    public function show(Item $item)
    {
        $item->load('stock','transactions.user');
        return view('admin.items.show', compact('item'));
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return back()->with('success','Item dihapus');
    }
}
