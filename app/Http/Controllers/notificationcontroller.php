<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    // List user notifications
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->get();

        return response()->json($notifications);
    }

    // Mark as read
    public function markRead(Notification $notification)
    {
        $this->authorize('update', $notification); // ensure user owns this notification
        $notification->update(['read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    // Send notification (internal function)
    public static function send($userId, $type, $message)
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
        ]);
    }
}
