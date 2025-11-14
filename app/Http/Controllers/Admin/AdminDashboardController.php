<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil 5 request terbaru + relasi user & item dari RequestItem
        $latestRequests = RequestModel::with(['requester', 'items.item'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('latestRequests'));
    }
}
