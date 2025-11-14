<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Item;
use App\Models\StockTransaction;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * LIST PO
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::latest()->get();

        return view('admin.purchase_orders.index', compact('purchaseOrders'));
    }


    /**
     * CREATE PO FORM
     */
    public function create()
    {
        $items = Item::orderBy('name')->get();

        return view('admin.purchase_orders.create', compact('items'));
    }


    /**
     * STORE PO + ITEMS
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_name'   => 'required',
            'item_id.*'       => 'required|exists:items,id',
            'quantity.*'      => 'required|numeric|min:1',
            'price.*'         => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {

            $poNumber = 'PO-' . date('Ymd') . '-' . str_pad(rand(1,9999),4,'0',STR_PAD_LEFT);

            $po = PurchaseOrder::create([
                'po_number'     => $poNumber,
                'supplier_name' => $request->supplier_name,
                'total_price'   => 0,
                'status'        => 'pending',
                'user_id'       => auth()->id(),
            ]);

            $total = 0;

            foreach ($request->item_id as $index => $itemId) {

                $qty   = $request->quantity[$index];
                $price = $request->price[$index];

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'item_id'           => $itemId,
                    'quantity'          => $qty,
                    'price'             => $price,
                ]);

                $total += ($qty * $price);
            }

            $po->update(['total_price' => $total]);

            DB::commit();

            return redirect()
                ->route('admin.purchase-orders.index')
                ->with('success', 'Purchase Order berhasil dibuat.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    /**
     * SHOW PO DETAIL
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('items.item');

        return view('admin.purchase_orders.show', compact('purchaseOrder'));
    }


    /**
     * EDIT PO FORM
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $items = Item::orderBy('name')->get();
        $purchaseOrder->load('items');

        return view('admin.purchase_orders.edit', compact('purchaseOrder', 'items'));
    }



    /**
     * UPDATE PO + ITEMS
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'supplier_name'   => 'required',
            'item_id.*'       => 'required|exists:items,id',
            'quantity.*'      => 'required|numeric|min:1',
            'price.*'         => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {

            // Hapus item lama
            PurchaseOrderItem::where('purchase_order_id', $purchaseOrder->id)->delete();

            $total = 0;

            foreach ($request->item_id as $key => $itemId) {

                $qty   = $request->quantity[$key];
                $price = $request->price[$key];

                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_id'           => $itemId,
                    'quantity'          => $qty,
                    'price'             => $price,
                ]);

                $total += $qty * $price;
            }

            $purchaseOrder->update([
                'supplier_name' => $request->supplier_name,
                'total_price'   => $total
            ]);

            DB::commit();

            return redirect()
                ->route('admin.purchase-orders.index')
                ->with('success', 'Purchase Order berhasil diperbarui.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }



    /**
     * DELETE PO
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'PO yang sudah diterima tidak dapat dihapus.');
        }

        $purchaseOrder->items()->delete();
        $purchaseOrder->delete();

        return back()->with('success', 'Purchase Order berhasil dihapus.');
    }



    /**
     * MARK PO AS RECEIVED + UPDATE STOCK
     */
    public function receive(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'PO ini sudah diterima sebelumnya.');
        }

        DB::beginTransaction();

        try {

            foreach ($purchaseOrder->items as $poItem) {

                // Update stok
                $stock = StockItem::firstOrCreate(
                    ['item_id' => $poItem->item_id],
                    ['quantity' => 0]
                );

                $stock->quantity += $poItem->quantity;
                $stock->save();

                // Buat transaksi stok
                StockTransaction::create([
                    'item_id'  => $poItem->item_id,
                    'type'     => 'in',
                    'quantity' => $poItem->quantity,
                    'source'   => 'PO #' . $purchaseOrder->id,
                ]);
            }

            $purchaseOrder->update(['status' => 'received']);

            DB::commit();

            return back()->with('success', 'Barang dari PO berhasil diterima.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
