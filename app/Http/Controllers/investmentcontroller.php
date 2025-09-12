<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    // Display all investments for the logged-in user
    public function index()
    {
        $investments = Investment::where('user_id', Auth::id())->with('property')->paginate(12);

        return view('investments.index', compact('investments'));
    }

    // Show specific investment
    public function show(Investment $investment)
    {
        // Vérifier que l'investissement appartient à l'utilisateur
        if ($investment->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $investment->load('property');
        return view('investments.show', compact('investment'));
    }

    // Show form to create new investment
    public function create()
    {
        $properties = Property::where('status', 'published')->get();

        return view('dashboard.create_investment', compact('properties'));
    }

    // Store new investment
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        $property = Property::findOrFail($request->property_id);

        // Calculate ROI (simplified)
        $roi = ($property->expected_roi) ?? 10;

        Investment::create([
            'user_id' => Auth::id(),
            'property_id' => $request->property_id,
            'amount' => $request->amount,
            'roi' => $roi,
            'status' => 'active',
        ]);

        return redirect()->route('investments.index')->with('success', 'Investment added successfully!');
    }

    // Show investment details
    public function show(Investment $investment)
    {
        $this->authorize('view', $investment);

        return view('dashboard.show_investment', compact('investment'));
    }

    // Delete investment
    public function destroy(Investment $investment)
    {
        $this->authorize('delete', $investment);
        $investment->delete();

        return redirect()->route('investments.index')->with('success', 'Investment deleted.');
    }
}
