<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->paginate(20);
        return view('partials.notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id = null)
    {
        $user = auth()->user();

        if ($id) {
            $notification = $user->notifications()->where('id', $id)->first();
            if ($notification) $notification->markAsRead();
        } else {
            $user->unreadNotifications->markAsRead();
        }

        return back();
    }
}
