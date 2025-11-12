<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->limit(10)->get();

        // Optional: Mark notifications as read when fetched
        // $user->unreadNotifications->markAsRead();

        return response()->json($notifications);
    }
}

