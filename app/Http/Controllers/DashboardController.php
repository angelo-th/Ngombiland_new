<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Investment;
use App\Models\User;

class DashboardController extends Controller
{
    // Show the dashboard for all users and visitors
    public function index()
    {
        $stats = [
            [
                'value' => Property::count(),
                'label' => 'Properties'
            ],
            [
                'value' => Investment::count(),
                'label' => 'Investments'
            ],
            [
                'value' => User::count(),
                'label' => 'Users'
            ]
        ];

        $recentActivities = [
            [
                'icon' => 'fa-home',
                'description' => 'New property listed in Douala',
                'time' => 'Just now'
            ],
            [
                'icon' => 'fa-money-bill',
                'description' => 'New investment received',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'fa-user',
                'description' => 'New user registration',
                'time' => '3 hours ago'
            ]
        ];

        // Get count of unread messages for the current user
        $unreadMessages = 0;
        if (auth()->check()) {
            $unreadMessages = auth()->user()->unreadMessages()->count();
        }

        return view('dashboard', compact('stats', 'recentActivities', 'unreadMessages'));
    }
}
