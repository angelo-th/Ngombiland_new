<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Display all reports for agent
    public function index()
    {
        $user = Auth::user();

        // Only agents or admin can view reports
        $reports = $user->role == 'agent' ? $user->reports()->with('property')->latest()->get() : Report::with('property', 'agent')->latest()->get();

        return view('dashboard.reports.index', [
            'reports' => $reports,
        ]);
    }

    // Create new report form
    public function create($propertyId)
    {
        $property = Property::findOrFail($propertyId);

        return view('dashboard.reports.create', compact('property'));
    }

    // Store report
    public function store(Request $request, $propertyId)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $property = Property::findOrFail($propertyId);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        $report = Report::create([
            'agent_id' => $user->id,
            'property_id' => $property->id,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image' => $imagePath,
            'status' => 'pending', // pending until verified by admin
        ]);

        return redirect()->route('reports.index')->with('success', 'Report submitted successfully.');
    }

    // Admin can verify report
    public function verify(Request $request, $reportId)
    {
        $report = Report::findOrFail($reportId);
        $report->status = 'verified';
        $report->verified_by = Auth::id();
        $report->verified_at = now();
        $report->save();

        return redirect()->back()->with('success', 'Report verified successfully.');
    }

    // Admin can reject report
    public function reject(Request $request, $reportId)
    {
        $report = Report::findOrFail($reportId);
        $report->status = 'rejected';
        $report->verified_by = Auth::id();
        $report->verified_at = now();
        $report->save();

        return redirect()->back()->with('success', 'Report rejected.');
    }
}
// app/Http/Controllers/AgentReportController.php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class AgentReportController extends Controller
{
    // List all reports
    public function index()
    {
        $reports = Report::with(['agent', 'property'])->get();

        return response()->json($reports);
    }

    // Update report (verification by admin)
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        $report->status = $request->status;
        $report->save();

        return response()->json(['message' => "Report status updated to {$report->status}"]);
    }

    // Delete a report
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return response()->json(['message' => 'Report deleted successfully']);
    }
}
