<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Services\StockService;
use Illuminate\Http\Request as HttpRequest;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $po = PurchaseOrder::with('request')->orderBy('created_at','desc')->get();
        return view('finance.po.index', compact('po'));
    }

    public function create()
    {
        // List permintaan yang sudah di-forward oleh admin
        $requests = Request::where('status','forwarded')->get();
        return view('finance.po.create', compact('requests'));
    }

    public function store(HttpRequest $request)
    {
        $req = Request::findOrFail($request->request_id);

        $poNumber = "PO-" . now()->format('YmdHis');

        $po = PurchaseOrder::create([
            'po_number' => $poNumber,
            'request_id' => $req->id,
            'user_id' => auth()->id(),
            'status' => 'draft',
            'supplier_name' => $request->supplier_name,
            'supplier_contact' => $request->supplier_contact,
            'due_date' => $request->due_date,
        ]);

        // copy from request items
        foreach ($req->items as $i) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'item_id' => $i->item_id,
                'qty_requested' => $i->qty_requested,
                'qty_ordered' => $i->qty_approved ?? $i->qty_requested,
            ]);
        }

        // ubah status request
        $req->update(['status'=>'approved']);

        return redirect()->route('finance.po.show',$po->id)
            ->with('success','Purchase Order dibuat.');
    }

    public function show(PurchaseOrder $po)
    {
        $po->load('items.item','request.requester');
        return view('finance.po.show', compact('po'));
    }

    public function receive(PurchaseOrder $po, HttpRequest $request, StockService $stock)
    {
        foreach ($po->items as $item) {
            $received = $request->qty_received[$item->id] ?? 0;

            // update received amount
            $item->qty_received += $received;
            $item->save();

            // update stock
            if ($received > 0) {
                $stock->increase($item->item_id, $received, [
                    'ref_type' => 'po',
                    'ref_id' => $po->id,
                    'user_id' => auth()->id(),
                    'note' => "PO Received: {$po->po_number}",
                ]);
            }
        }

        $po->update(['status'=>'received']);

        return back()->with('success','Barang berhasil diterima.');
    }
}

