<?php

namespace App\Http\Controllers;

use App\Models\CrowdfundingProject;
use App\Services\RentalDistributionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalDistributionController extends Controller
{
    protected $rentalDistributionService;

    public function __construct(RentalDistributionService $rentalDistributionService)
    {
        $this->rentalDistributionService = $rentalDistributionService;
    }

    /**
     * Afficher la page de distribution des loyers
     */
    public function index()
    {
        $projects = CrowdfundingProject::where('status', 'funded')
            ->with(['property', 'investments.user'])
            ->get();

        return view('rental-distribution.index', compact('projects'));
    }

    /**
     * Afficher les détails d'un projet pour la distribution
     */
    public function show(CrowdfundingProject $project)
    {
        $this->authorize('view', $project);
        
        $project->load(['property', 'investments.user']);
        $distributionHistory = $this->rentalDistributionService->getDistributionHistory($project);
        
        return view('rental-distribution.show', compact('project', 'distributionHistory'));
    }

    /**
     * Traiter la distribution des loyers
     */
    public function distribute(Request $request, CrowdfundingProject $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'rental_amount' => 'required|numeric|min:0',
        ]);

        try {
            $distribution = $this->rentalDistributionService->distributeRent(
                $project, 
                $request->rental_amount
            );

            return redirect()->route('rental-distribution.show', $project)
                ->with('success', 'Distribution des loyers effectuée avec succès !');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la distribution : ' . $e->getMessage());
        }
    }

    /**
     * API pour obtenir les revenus estimés d'un investisseur
     */
    public function getEstimatedIncome(CrowdfundingProject $project)
    {
        $userId = Auth::id();
        $estimatedIncome = $this->rentalDistributionService->calculateEstimatedMonthlyIncome($userId, $project);
        
        return response()->json([
            'estimated_monthly_income' => $estimatedIncome,
            'currency' => 'XAF'
        ]);
    }

    /**
     * Historique des distributions pour un utilisateur
     */
    public function userHistory()
    {
        $userId = Auth::id();
        
        $distributions = \App\Models\RentalDistributionDetail::where('user_id', $userId)
            ->with(['rentalDistribution.crowdfundingProject.property'])
            ->orderBy('distributed_at', 'desc')
            ->paginate(10);

        return view('rental-distribution.user-history', compact('distributions'));
    }
}
