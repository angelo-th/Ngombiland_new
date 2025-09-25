<?php

namespace App\Http\Controllers;

use App\Models\CrowdfundingProject;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CrowdfundingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = CrowdfundingProject::with(['user', 'property'])
            ->active()
            ->latest()
            ->paginate(12);

        return view('crowdfunding.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Auth::user()->properties()->where('status', 'available')->get();
        return view('crowdfunding.create', compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'property_id' => 'required|exists:properties,id',
            'total_amount' => 'required|numeric|min:1000000', // Minimum 1M FCFA
            'total_shares' => 'required|integer|min:10|max:10000',
            'expected_roi' => 'required|numeric|min:5|max:50', // 5% à 50%
            'funding_deadline' => 'required|date|after:today',
            'risks' => 'nullable|string',
            'benefits' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['price_per_share'] = $request->total_amount / $request->total_shares;
        $data['status'] = 'draft';

        // Gestion des images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('crowdfunding', 'public');
                $images[] = $path;
            }
            $data['images'] = $images;
        }

        CrowdfundingProject::create($data);

        return redirect()->route('crowdfunding.index')
            ->with('success', 'Projet de crowdfunding créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(CrowdfundingProject $crowdfunding)
    {
        $crowdfunding->load(['user', 'property', 'investments.user']);
        
        // Calculer les statistiques
        $stats = [
            'total_investors' => $crowdfunding->investments()->confirmed()->count(),
            'average_investment' => $crowdfunding->investments()->confirmed()->avg('amount_invested') ?? 0,
            'days_remaining' => max(0, now()->diffInDays($crowdfunding->funding_deadline, false)),
        ];

        return view('crowdfunding.show', compact('crowdfunding', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CrowdfundingProject $crowdfunding)
    {
        $this->authorize('update', $crowdfunding);
        
        $properties = Auth::user()->properties()->where('status', 'available')->get();
        return view('crowdfunding.edit', compact('crowdfunding', 'properties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CrowdfundingProject $crowdfunding)
    {
        $this->authorize('update', $crowdfunding);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'property_id' => 'required|exists:properties,id',
            'total_amount' => 'required|numeric|min:1000000',
            'total_shares' => 'required|integer|min:10|max:10000',
            'expected_roi' => 'required|numeric|min:5|max:50',
            'funding_deadline' => 'required|date|after:today',
            'risks' => 'nullable|string',
            'benefits' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['price_per_share'] = $request->total_amount / $request->total_shares;

        // Gestion des images
        if ($request->hasFile('images')) {
            $images = $crowdfunding->images ?? [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('crowdfunding', 'public');
                $images[] = $path;
            }
            $data['images'] = $images;
        }

        $crowdfunding->update($data);

        return redirect()->route('crowdfunding.show', $crowdfunding)
            ->with('success', 'Projet mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CrowdfundingProject $crowdfunding)
    {
        $this->authorize('delete', $crowdfunding);
        
        $crowdfunding->delete();
        
        return redirect()->route('crowdfunding.index')
            ->with('success', 'Projet supprimé avec succès !');
    }

    /**
     * Activer un projet de crowdfunding
     */
    public function activate(CrowdfundingProject $crowdfunding)
    {
        $this->authorize('update', $crowdfunding);
        
        $crowdfunding->update(['status' => 'active']);
        
        return back()->with('success', 'Projet activé avec succès !');
    }

    /**
     * Investir dans un projet
     */
    public function invest(Request $request, CrowdfundingProject $crowdfunding)
    {
        $request->validate([
            'shares' => 'required|integer|min:1|max:' . $crowdfunding->remaining_shares,
        ]);

        $shares = $request->shares;
        $amount = $shares * $crowdfunding->price_per_share;
        $user = Auth::user();

        // Check if the user has enough funds
        if ($user->wallet->balance < $amount) {
            return back()->with('error', 'Insufficient funds in your wallet.');
        }

        // Deduct the amount from the user's wallet
        $user->wallet->balance -= $amount;
        $user->wallet->save();

        // Create a transaction record
        Transaction::create([
            'user_id' => $user->id,
            'wallet_id' => $user->wallet->id,
            'type' => 'investment',
            'amount' => $amount,
            'description' => 'Investment in ' . $crowdfunding->title,
            'status' => 'completed',
        ]);

        $investment = $crowdfunding->investments()->create([
            'user_id' => $user->id,
            'shares_purchased' => $shares,
            'amount_invested' => $amount,
            'price_per_share' => $crowdfunding->price_per_share,
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Update project statistics
        $crowdfunding->increment('shares_sold', $shares);
        $crowdfunding->increment('amount_raised', $amount);

        // Check if the project is fully funded
        if ($crowdfunding->fresh()->is_fully_funded) {
            $crowdfunding->update(['status' => 'funded']);
        }

        return back()->with('success', 'Investment successful!');
    }
}
