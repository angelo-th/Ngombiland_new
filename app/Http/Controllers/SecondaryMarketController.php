<?php

namespace App\Http\Controllers;

use App\Models\CrowdfundingInvestment;
use App\Models\SecondaryMarketListing;
use App\Models\SecondaryMarketOffer;
use App\Services\SecondaryMarketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecondaryMarketController extends Controller
{
    protected $secondaryMarketService;

    public function __construct(SecondaryMarketService $secondaryMarketService)
    {
        $this->secondaryMarketService = $secondaryMarketService;
    }

    /**
     * Afficher le marketplace secondaire
     */
    public function index(Request $request)
    {
        $filters = $request->only(['project_id', 'min_price', 'max_price']);
        $listings = $this->secondaryMarketService->getActiveListings($filters);
        
        // Récupérer tous les projets pour le filtre
        $projects = \App\Models\CrowdfundingProject::where('status', 'funded')
            ->with('property')
            ->get();

        return view('secondary-market.index', compact('listings', 'projects', 'filters'));
    }

    /**
     * Afficher le formulaire de création d'annonce
     */
    public function create()
    {
        $investments = CrowdfundingInvestment::where('user_id', Auth::id())
            ->where('status', 'confirmed')
            ->with(['crowdfundingProject.property'])
            ->get();

        return view('secondary-market.create', compact('investments'));
    }

    /**
     * Créer une nouvelle annonce
     */
    public function store(Request $request)
    {
        $request->validate([
            'crowdfunding_investment_id' => 'required|exists:crowdfunding_investments,id',
            'shares_for_sale' => 'required|integer|min:1',
            'price_per_share' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $data = $request->all();
            $data['user_id'] = Auth::id();
            
            $listing = $this->secondaryMarketService->createListing($data);

            return redirect()->route('secondary-market.show', $listing)
                ->with('success', 'Annonce créée avec succès !');
                
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Afficher une annonce
     */
    public function show(SecondaryMarketListing $listing)
    {
        $listing->load(['user', 'crowdfundingInvestment.crowdfundingProject.property', 'offers.user']);
        
        return view('secondary-market.show', compact('listing'));
    }

    /**
     * Faire une offre sur une annonce
     */
    public function makeOffer(Request $request, SecondaryMarketListing $listing)
    {
        $request->validate([
            'shares_requested' => 'required|integer|min:1|max:' . $listing->shares_for_sale,
            'offer_price_per_share' => 'required|numeric|min:0',
            'message' => 'nullable|string|max:500',
        ]);

        try {
            $data = $request->all();
            $data['user_id'] = Auth::id();
            $data['secondary_market_listing_id'] = $listing->id;
            
            $offer = $this->secondaryMarketService->makeOffer($data);

            return back()->with('success', 'Offre envoyée avec succès !');
                
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Accepter une offre
     */
    public function acceptOffer(SecondaryMarketOffer $offer)
    {
        try {
            $this->secondaryMarketService->acceptOffer($offer);

            return back()->with('success', 'Offre acceptée avec succès !');
                
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Rejeter une offre
     */
    public function rejectOffer(SecondaryMarketOffer $offer)
    {
        $this->secondaryMarketService->rejectOffer($offer);

        return back()->with('success', 'Offre rejetée');
    }

    /**
     * Mes annonces
     */
    public function myListings()
    {
        $listings = SecondaryMarketListing::where('user_id', Auth::id())
            ->with(['crowdfundingInvestment.crowdfundingProject.property'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('secondary-market.my-listings', compact('listings'));
    }

    /**
     * Mes offres
     */
    public function myOffers()
    {
        $offers = $this->secondaryMarketService->getUserOffers(Auth::id());

        return view('secondary-market.my-offers', compact('offers'));
    }

    /**
     * Offres reçues
     */
    public function receivedOffers()
    {
        $offers = $this->secondaryMarketService->getReceivedOffers(Auth::id());

        return view('secondary-market.received-offers', compact('offers'));
    }

    /**
     * Annuler une annonce
     */
    public function cancelListing(SecondaryMarketListing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403);
        }

        $listing->update(['status' => 'cancelled']);

        return back()->with('success', 'Annonce annulée');
    }
}
