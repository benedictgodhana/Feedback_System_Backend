<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Fetch notifications from the database
        $notifications = Notification::all();

        // Return notifications as JSON response
        return response()->json($notifications);
    }

    public function getUnreadNotificationCount()
    {
        $unreadCount = Notification::where('read', false)->count();

        return response()->json(['count' => $unreadCount]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read = true;
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }
}
