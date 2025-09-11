<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Property;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Accès non autorisé');
            }

            return $next($request);
        });
    }

    public function users()
    {
        $users = User::with('properties')->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'properties' => Property::count(),
            'investments' => Investment::count(),
            'total_invested' => Investment::sum('amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
