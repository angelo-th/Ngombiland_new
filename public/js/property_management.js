
    function propertiesApp() {
        return {
            userBalance: 125750,
            currentStep: 1,
            showAddPropertyModal: false,
            showPropertyDetailModal: false,
            showFavorites: false,
            searchQuery: '',
            filterType: '',
            filterStatus: '',
            selectedProperty: null,
            
            newProperty: {
                title: '',
                type: '',
                price: 0,
                surface: 0,
                transaction: 'vente',
                bedrooms: 0,
                bathrooms: 0,
                floor: 0,
                yearBuilt: new Date().getFullYear(),
                location: '',
                description: '',
                photos: []
            },
            
            properties: [
                {
                    id: 1,
                    title: 'Modern villa in Bastos',
                    type: 'Villa',
                    price: 85000000,
                    location: 'Bastos, Yaoundé',
                    bedrooms: 4,
                    bathrooms: 3,
                    surface: 250,
                    status: 'active',
                    image: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    views: 156,
                    contacts: 12,
                    favoriteCount: 8,
                    isFavorite: false,
                    description: 'Beautiful modern villa with swimming pool, landscaped garden and panoramic view.'
                },
                {
                    id: 2,
                    title: '3-bedroom apartment in Bonanjo',
                    type: 'Apartment',
                    price: 25000000,
                    location: 'Bonanjo, Douala',
                    bedrooms: 2,
                    bathrooms: 2,
                    surface: 85,
                    status: 'pending',
                    image: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    views: 89,
                    contacts: 5,
                    favoriteCount: 3,
                    isFavorite: true,
                    description: 'Modern apartment downtown with all amenities.'
                },
                {
                    id: 3,
                    title: 'Buildable land in Odza',
                    type: 'Land',
                    price: 12000000,
                    location: 'Odza, Yaoundé',
                    bedrooms: 0,
                    bathrooms: 0,
                    surface: 500,
                    status: 'active',
                    image: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    views: 67,
                    contacts: 8,
                    favoriteCount: 5,
                    isFavorite: false,
                    description: 'Flat land, well located with proper land title.'
                }
            ],
            
            get filteredProperties() {
                return this.properties.filter(property => {
                    const matchesSearch = !this.searchQuery || 
                        property.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        property.location.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const matchesType = !this.filterType || property.type.toLowerCase() === this.filterType;
                    const matchesStatus = !this.filterStatus || property.status === this.filterStatus;
                    
                    return matchesSearch && matchesType && matchesStatus;
                });
            },
            
            get favoriteProperties() {
                return this.properties.filter(property => property.isFavorite);
            },
            
            formatCurrency(amount) {
                if (!amount) return '0 FCFA';
                return new Intl.NumberFormat('fr-FR').format(amount) + ' FCFA';
            },
            
            getStatusClass(status) {
                const classes = {
                    active: 'bg-green-500 text-white',
                    pending: 'bg-yellow-500 text-white',
                    sold: 'bg-blue-500 text-white',
                    rented: 'bg-purple-500 text-white'
                };
                return classes[status] || 'bg-gray-500 text-white';
            },
            
            getStatusText(status) {
                const texts = {
                    active: 'Active',
                    pending: 'Pending',
                    sold: 'Sold',
                    rented: 'Rented'
                };
                return texts[status] || 'Unknown';
            },
            
            toggleFavorite(propertyId) {
                const property = this.properties.find(p => p.id === propertyId);
                if (property) {
                    property.isFavorite = !property.isFavorite;
                    property.favoriteCount += property.isFavorite ? 1 : -1;
                }
            },
            
            viewProperty(propertyId) {
                this.selectedProperty = this.properties.find(p => p.id === propertyId);
                this.showPropertyDetailModal = true;
            },
            
            editProperty(propertyId) {
                alert(`Redirecting to edit property ${propertyId}`);
            },
            
            promoteProperty(propertyId) {
                if (confirm('Promote this listing for 2,000 FCFA?')) {
                    if (this.userBalance >= 2000) {
                        this.userBalance -= 2000;
                        alert('Listing promoted successfully!');
                    } else {
                        alert('Insufficient balance. Please top up your account.');
                    }
                }
            },
            
            deleteProperty(propertyId) {
                if (confirm('Are you sure you want to delete this listing?')) {
                    this.properties = this.properties.filter(p => p.id !== propertyId);
                    this.showPropertyDetailModal = false;
                }
            },
            
            nextStep() {
                if (this.validateCurrentStep()) {
                    this.currentStep++;
                }
            },
            
            validateCurrentStep() {
                if (this.currentStep === 1) {
                    if (!this.newProperty.title || !this.newProperty.type || !this.newProperty.price || !this.newProperty.location) {
                        alert('Please fill all required fields.');
                        return false;
                    }
                }
                return true;
            },
            
            publishProperty() {
                if (this.userBalance >= 1500) {
                    if (confirm('Publish this listing for 1,500 FCFA?')) {
                        this.userBalance -= 1500;
                        
                        // Add new property
                        const newId = Math.max(...this.properties.map(p => p.id)) + 1;
                        this.properties.unshift({
                            id: newId,
                            ...this.newProperty,
                            status: 'pending',
                            image: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            views: 0,
                            contacts: 0,
                            favoriteCount: 0,
                            isFavorite: false
                        });
                        
                        // Reset form
                        this.newProperty = {
                            title: '',
                            type: '',
                            price: 0,
                            surface: 0,
                            transaction: 'vente',
                            bedrooms: 0,
                            bathrooms: 0,
                            floor: 0,
                            yearBuilt: new Date().getFullYear(),
                            location: '',
                            description: '',
                            photos: []
                        };
                        
                        this.currentStep = 1;
                        this.showAddPropertyModal = false;
                        alert('Listing published successfully! It will be visible after verification.');
                    }
                } else {
                    alert('Insufficient balance. Please top up your account.');
                }
            },
            
            removePhoto(index) {
                this.newProperty.photos.splice(index, 1);
            }
        }
    }
