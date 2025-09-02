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
            'properties_count' => Property::count(),
            'investments_count' => Investment::count(),
            'users_count' => User::count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
