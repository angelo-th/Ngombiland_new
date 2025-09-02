<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Investment;
use App\Models\Transaction;

class DashboardController extends Controller
{
    // Show admin dashboard metrics
    public function index()
    {
        // Count total users, properties, investments
        $totalUsers = User::count();
        $totalProperties = Property::count();
        $totalInvestments = Investment::count();
        $totalTransactions = Transaction::count();
        
        // Latest 5 transactions
        $latestTransactions = Transaction::orderBy('created_at', 'desc')->take(5)->get();

        // Return dashboard view with metrics
        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalProperties',
            'totalInvestments',
            'totalTransactions',
            'latestTransactions'
        ));
    }

    // Fetch notifications (AJAX)
    public function fetchNotifications()
    {
        $notifications = auth()->user()->unreadNotifications()->take(10)->get();
        return response()->json($notifications);
    }
    // Mark notification as read
    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error'], 404);
    }
}