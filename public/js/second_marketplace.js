function secondaryMarketplace(userData = {}, portfolioData = {}, projectsData = [], listingsData = []) {
    return {
        // Données principales
        user: userData,
        portfolio: portfolioData,
        projects: projectsData,
        listings: listingsData,

        // Filtres marketplace
        filters: {
            project: '',
            sort: 'roi_desc'
        },

        // Modals
        sellModalOpen: false,
        buyModalOpen: false,
        selectedListing: {},
        
        // Formulaires
        saleForm: {
            projectId: '',
            quantity: 1,
            pricePerShare: 0
        },
        buyForm: {
            quantity: 1
        },

        // Méthodes de formatage
        formatCurrency(value) {
            if (!value) return '0 FCFA';
            return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XAF', minimumFractionDigits: 0 }).format(value);
        },

        // Ouvrir modal vente
        openSellModal() {
            this.sellModalOpen = true;
            this.saleForm = {
                projectId: '',
                quantity: 1,
                pricePerShare: 0
            };
        },

        // Ouvrir modal achat
        openBuyModal(listing) {
            this.selectedListing = listing;
            this.buyForm.quantity = 1;
            this.buyModalOpen = true;
        },

        // Obtenir parts possédées pour un projet
        getOwnedShares(projectId) {
            const share = this.portfolio.shares.find(s => s.projectId == projectId);
            return share ? share.quantity : 0;
        },

        // Obtenir ROI actuel pour un projet
        getProjectROI(projectId) {
            const share = this.portfolio.shares.find(s => s.projectId == projectId);
            return share ? share.currentROI : 0;
        },

        // Prix recommandé (exemple simple : moyenne)
        get recommendedPrice() {
            if (!this.saleForm.projectId) return 0;
            const share = this.portfolio.shares.find(s => s.projectId == this.saleForm.projectId);
            return share ? share.pricePerShare : 0;
        },

        get priceDifference() {
            if (!this.saleForm.pricePerShare || !this.recommendedPrice) return 0;
            return Math.round(((this.saleForm.pricePerShare - this.recommendedPrice) / this.recommendedPrice) * 100);
        },

        // Confirmer vente
        submitSale() {
            if (!this.saleForm.projectId || this.saleForm.quantity < 1 || this.saleForm.pricePerShare <= 0) {
                alert('Veuillez remplir tous les champs correctement.');
                return;
            }

            // Simulation d'ajout à la marketplace
            const project = this.projects.find(p => p.id == this.saleForm.projectId);
            this.listings.push({
                id: Date.now(),
                projectId: this.saleForm.projectId,
                projectName: project.name,
                projectLocation: project.location,
                projectImage: project.image,
                availableShares: this.saleForm.quantity,
                pricePerShare: this.saleForm.pricePerShare,
                currentROI: this.getProjectROI(this.saleForm.projectId),
                sellerName: this.user.name,
                sellerRating: 4.5,
                projectStatus: 'Actif'
            });

            this.sellModalOpen = false;
            alert('Votre offre a été publiée sur le marketplace.');
        },

        // Confirmer achat
        confirmPurchase() {
            if (this.buyForm.quantity < 1 || this.buyForm.quantity > this.selectedListing.availableShares) {
                alert('Quantité invalide.');
                return;
            }

            const totalPrice = this.buyForm.quantity * this.selectedListing.pricePerShare * 1.02; // 2% frais
            alert(`Vous avez acheté ${this.buyForm.quantity} parts pour ${this.formatCurrency(totalPrice)}.`);

            // Mise à jour quantité disponible
            this.selectedListing.availableShares -= this.buyForm.quantity;
            if (this.selectedListing.availableShares <= 0) {
                this.listings = this.listings.filter(l => l.id !== this.selectedListing.id);
            }

            this.buyModalOpen = false;
        },

        // Edit / Cancel Listing
        editListing(item) {
            this.saleForm.projectId = item.projectId;
            this.saleForm.quantity = item.availableShares;
            this.saleForm.pricePerShare = item.pricePerShare;
            this.sellModalOpen = true;
        },

        cancelListing(item) {
            if (confirm('Voulez-vous vraiment annuler cette offre ?')) {
                this.listings = this.listings.filter(l => l.id !== item.id);
            }
        },

        // Filtrage et tri du marketplace
        get filteredListings() {
            let results = this.listings;

            if (this.filters.project) {
                results = results.filter(l => l.projectId == this.filters.project);
            }

            switch(this.filters.sort) {
                case 'roi_desc': results.sort((a,b) => b.currentROI - a.currentROI); break;
                case 'roi_asc': results.sort((a,b) => a.currentROI - b.currentROI); break;
                case 'price_desc': results.sort((a,b) => b.pricePerShare - a.pricePerShare); break;
                case 'price_asc': results.sort((a,b) => a.pricePerShare - b.pricePerShare); break;
                case 'recent': results.sort((a,b) => b.id - a.id); break;
            }

            return results;
        }
    }
}
