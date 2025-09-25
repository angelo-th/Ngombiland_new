<?php

namespace App\Services;

use App\Models\SecondaryMarketListing;
use App\Models\SecondaryMarketOffer;
use App\Models\CrowdfundingInvestment;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SecondaryMarketService
{
    /**
     * Créer une annonce de vente sur le marché secondaire
     */
    public function createListing(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Vérifier que l'utilisateur possède bien ces parts
            $investment = CrowdfundingInvestment::where('id', $data['crowdfunding_investment_id'])
                ->where('user_id', $data['user_id'])
                ->where('status', 'confirmed')
                ->first();

            if (!$investment) {
                throw new \Exception('Investissement non trouvé ou non confirmé');
            }

            // Vérifier que l'utilisateur a assez de parts à vendre
            if ($investment->shares_purchased < $data['shares_for_sale']) {
                throw new \Exception('Vous ne possédez pas assez de parts à vendre');
            }

            // Calculer le prix total
            $totalPrice = $data['shares_for_sale'] * $data['price_per_share'];

            // Créer l'annonce
            $listing = SecondaryMarketListing::create([
                'user_id' => $data['user_id'],
                'crowdfunding_investment_id' => $data['crowdfunding_investment_id'],
                'shares_for_sale' => $data['shares_for_sale'],
                'price_per_share' => $data['price_per_share'],
                'total_price' => $totalPrice,
                'status' => 'active',
                'description' => $data['description'] ?? '',
                'expires_at' => now()->addDays(30), // Expire dans 30 jours
            ]);

            return $listing;
        });
    }

    /**
     * Faire une offre sur une annonce
     */
    public function makeOffer(array $data)
    {
        return DB::transaction(function () use ($data) {
            $listing = SecondaryMarketListing::findOrFail($data['secondary_market_listing_id']);

            // Vérifier que l'annonce est active
            if ($listing->status !== 'active' || $listing->is_expired) {
                throw new \Exception('Cette annonce n\'est plus disponible');
            }

            // Vérifier que l'utilisateur ne fait pas d'offre sur sa propre annonce
            if ($listing->user_id === $data['user_id']) {
                throw new \Exception('Vous ne pouvez pas faire d\'offre sur votre propre annonce');
            }

            // Vérifier que l'offre ne dépasse pas le nombre de parts disponibles
            if ($data['shares_requested'] > $listing->shares_for_sale) {
                throw new \Exception('Le nombre de parts demandé dépasse ce qui est disponible');
            }

            // Calculer le montant total de l'offre
            $totalOfferAmount = $data['shares_requested'] * $data['offer_price_per_share'];

            // Créer l'offre
            $offer = SecondaryMarketOffer::create([
                'user_id' => $data['user_id'],
                'secondary_market_listing_id' => $listing->id,
                'shares_requested' => $data['shares_requested'],
                'offer_price_per_share' => $data['offer_price_per_share'],
                'total_offer_amount' => $totalOfferAmount,
                'status' => 'pending',
                'message' => $data['message'] ?? '',
            ]);

            return $offer;
        });
    }

    /**
     * Accepter une offre
     */
    public function acceptOffer(SecondaryMarketOffer $offer)
    {
        return DB::transaction(function () use ($offer) {
            $listing = $offer->secondaryMarketListing;

            // Vérifier que l'offre est en attente
            if ($offer->status !== 'pending') {
                throw new \Exception('Cette offre ne peut plus être acceptée');
            }

            // Vérifier que l'annonce est toujours active
            if ($listing->status !== 'active') {
                throw new \Exception('Cette annonce n\'est plus active');
            }

            // Vérifier que l'acheteur a assez de fonds
            $buyerWallet = Wallet::where('user_id', $offer->user_id)->first();
            if (!$buyerWallet || $buyerWallet->balance < $offer->total_offer_amount) {
                throw new \Exception('L\'acheteur n\'a pas assez de fonds');
            }

            // Effectuer la transaction
            $this->processTransaction($offer);

            // Mettre à jour l'offre
            $offer->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            // Mettre à jour l'annonce
            $remainingShares = $listing->shares_for_sale - $offer->shares_requested;
            if ($remainingShares <= 0) {
                $listing->update([
                    'status' => 'sold',
                    'sold_at' => now(),
                ]);
            } else {
                $listing->update([
                    'shares_for_sale' => $remainingShares,
                    'total_price' => $remainingShares * $listing->price_per_share,
                ]);
            }

            // Créer un nouvel investissement pour l'acheteur
            $this->createNewInvestment($offer);

            return $offer;
        });
    }

    /**
     * Rejeter une offre
     */
    public function rejectOffer(SecondaryMarketOffer $offer)
    {
        $offer->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        return $offer;
    }

    /**
     * Traiter la transaction financière
     */
    private function processTransaction(SecondaryMarketOffer $offer)
    {
        $listing = $offer->secondaryMarketListing;
        $buyerWallet = Wallet::where('user_id', $offer->user_id)->first();
        $sellerWallet = Wallet::where('user_id', $listing->user_id)->first();

        // Débiter l'acheteur
        $buyerWallet->decrement('balance', $offer->total_offer_amount);

        // Créer la transaction de l'acheteur
        Transaction::create([
            'user_id' => $offer->user_id,
            'wallet_id' => $buyerWallet->id,
            'type' => 'secondary_market_purchase',
            'amount' => -$offer->total_offer_amount,
            'description' => 'Achat de parts sur le marché secondaire',
            'status' => 'completed',
            'reference' => 'SEC_' . Str::uuid(),
        ]);

        // Créditer le vendeur
        $sellerWallet->increment('balance', $offer->total_offer_amount);

        // Créer la transaction du vendeur
        Transaction::create([
            'user_id' => $listing->user_id,
            'wallet_id' => $sellerWallet->id,
            'type' => 'secondary_market_sale',
            'amount' => $offer->total_offer_amount,
            'description' => 'Vente de parts sur le marché secondaire',
            'status' => 'completed',
            'reference' => 'SEC_' . Str::uuid(),
        ]);
    }

    /**
     * Créer un nouvel investissement pour l'acheteur
     */
    private function createNewInvestment(SecondaryMarketOffer $offer)
    {
        $listing = $offer->secondaryMarketListing;
        $originalInvestment = $listing->crowdfundingInvestment;

        // Créer le nouvel investissement
        CrowdfundingInvestment::create([
            'user_id' => $offer->user_id,
            'crowdfunding_project_id' => $originalInvestment->crowdfunding_project_id,
            'shares_purchased' => $offer->shares_requested,
            'amount_invested' => $offer->total_offer_amount,
            'price_per_share' => $offer->offer_price_per_share,
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Réduire l'investissement original du vendeur
        $originalInvestment->decrement('shares_purchased', $offer->shares_requested);
        $originalInvestment->decrement('amount_invested', $offer->total_offer_amount);
    }

    /**
     * Obtenir les annonces actives
     */
    public function getActiveListings($filters = [])
    {
        $query = SecondaryMarketListing::with(['user', 'crowdfundingInvestment.crowdfundingProject.property'])
            ->active();

        if (isset($filters['project_id'])) {
            $query->whereHas('crowdfundingInvestment', function($q) use ($filters) {
                $q->where('crowdfunding_project_id', $filters['project_id']);
            });
        }

        if (isset($filters['min_price'])) {
            $query->where('price_per_share', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price_per_share', '<=', $filters['max_price']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(12);
    }

    /**
     * Obtenir les offres d'un utilisateur
     */
    public function getUserOffers($userId)
    {
        return SecondaryMarketOffer::with(['secondaryMarketListing.crowdfundingInvestment.crowdfundingProject.property'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Obtenir les offres reçues pour les annonces d'un utilisateur
     */
    public function getReceivedOffers($userId)
    {
        return SecondaryMarketOffer::with(['user', 'secondaryMarketListing.crowdfundingInvestment.crowdfundingProject.property'])
            ->whereHas('secondaryMarketListing', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
}
