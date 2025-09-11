<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['property', 'agent'])->latest()->paginate(20);

        return view('reports.index', compact('reports'));
    }

    public function create($propertyId)
    {
        $property = Property::findOrFail($propertyId);

        return view('reports.create', compact('property'));
    }

    public function store(Request $request, $propertyId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,verified,rejected',
        ]);

        Report::create([
            'property_id' => $propertyId,
            'agent_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('reports.index')->with('success', 'Rapport créé avec succès');
    }

    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }
}
