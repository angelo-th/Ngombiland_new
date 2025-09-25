<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Property;
use App\Models\User;
use App\Models\CrowdfundingProject;
use Illuminate\Http\Request;

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
            'properties_pending' => Property::where('status', 'pending')->count(),
            'properties_approved' => Property::where('status', 'approved')->count(),
            'crowdfunding_pending' => CrowdfundingProject::where('status', 'pending')->count(),
            'crowdfunding_active' => CrowdfundingProject::where('status', 'active')->count(),
            'investments' => Investment::count(),
            'total_invested' => Investment::sum('amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Gestion des propriétés
    public function properties(Request $request)
    {
        $query = Property::with('owner');
        
        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->paginate(20)->withQueryString();
        
        return view('admin.properties', compact('properties'));
    }

    // Valider une propriété
    public function approveProperty(Property $property)
    {
        $property->update(['status' => 'approved']);
        
        return redirect()->back()->with('success', 'Propriété approuvée avec succès');
    }

    // Rejeter une propriété
    public function rejectProperty(Request $request, Property $property)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);
        
        $property->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason
        ]);
        
        return redirect()->back()->with('success', 'Propriété rejetée avec succès');
    }

    // Gestion du crowdfunding
    public function crowdfunding(Request $request)
    {
        $query = CrowdfundingProject::with(['property', 'property.owner']);
        
        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        } else {
            // Par défaut, afficher tous les projets (draft, pending, active, etc.)
            $query->whereIn('status', ['draft', 'pending', 'active', 'rejected', 'completed']);
        }
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('property', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->latest()->paginate(20)->withQueryString();
        
        return view('admin.crowdfunding', compact('projects'));
    }

    // Passer un projet de draft à pending
    public function submitCrowdfunding(CrowdfundingProject $project)
    {
        if ($project->status !== 'draft') {
            return redirect()->back()->with('error', 'Seuls les projets en brouillon peuvent être soumis');
        }
        
        $project->update(['status' => 'pending']);
        
        return redirect()->back()->with('success', 'Projet soumis pour validation');
    }

    // Valider un projet crowdfunding
    public function approveCrowdfunding(CrowdfundingProject $project)
    {
        if ($project->status !== 'pending') {
            return redirect()->back()->with('error', 'Seuls les projets en attente peuvent être approuvés');
        }
        
        $project->update(['status' => 'active']);
        
        return redirect()->back()->with('success', 'Projet crowdfunding approuvé avec succès');
    }

    // Rejeter un projet crowdfunding
    public function rejectCrowdfunding(Request $request, CrowdfundingProject $project)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);
        
        $project->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason
        ]);
        
        return redirect()->back()->with('success', 'Projet crowdfunding rejeté avec succès');
    }
}
