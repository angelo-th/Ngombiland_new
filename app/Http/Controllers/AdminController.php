<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Investment;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
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
