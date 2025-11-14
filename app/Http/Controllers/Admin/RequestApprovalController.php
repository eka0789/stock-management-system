<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request;
use App\Models\RequestItem;
use Illuminate\Http\Request as HttpRequest;

class RequestApprovalController extends Controller
{
    public function index()
    {
        $requests = Request::where('status', 'pending')->get();
        return view('admin.requests.index', compact('requests'));
    }

    public function edit(Request $req)
    {
        $req->load('items.item','requester');
        return view('admin.requests.edit', compact('req'));
    }

    public function approve(Request $req, HttpRequest $request)
    {
        foreach ($req->items as $item) {
            $item->update([
                'qty_approved' => $request->qty_approved[$item->id] ?? $item->qty_requested
            ]);
        }

        $req->update(['status' => 'approved']);

        return redirect()->route('admin.requests.index')
            ->with('success', 'Permintaan disetujui.');
    }

    public function reject(Request $req)
    {
        $req->update(['status' => 'rejected']);
        return back()->with('success','Permintaan ditolak.');
    }

    public function forward(Request $req)
    {
        $req->update(['status' => 'forwarded']);
        return back()->with('success','Permintaan diteruskan ke Finance.');
    }
}
