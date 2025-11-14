<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\RequestItem;
use App\Models\Item;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    public function index()
    {
        $requests = Request::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.requests.index', compact('requests'));
    }

    public function create()
    {
        $items = Item::orderBy('name')->get();
        return view('leader.requests.create', compact('items'));
    }

    public function store(HttpRequest $request)
    {
        $request->validate([
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|numeric|min:0.1',
        ]);

        // Generate request code
        $code = "RQ-" . now()->format("YmdHis");

        $req = Request::create([
            'code' => $code,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'note' => $request->note
        ]);

        foreach ($request->items as $it) {
            RequestItem::create([
                'request_id' => $req->id,
                'item_id' => $it['item_id'],
                'qty_requested' => $it['qty'],
                'qty_approved' => null,
            ]);
        }

        return redirect()->route('leader.requests.index')
            ->with('success', 'Permintaan berhasil dibuat.');
    }

    public function show(Request $req)
    {
        $req->load('items.item', 'requester');
        return view('leader.requests.show', compact('req'));
    }
}
