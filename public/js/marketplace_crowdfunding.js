
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                        secondary: '#059669',
                        accent: '#F59E0B',
                        dark: '#1F2937'
                    },
                    boxShadow: {
                        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'
                    }
                }
            }
        }
    
        function crowdfundingApp() {
            return {
                userWallet: 350000,
                searchQuery: '',
                showFilters: false,
                showModal: false,
                selectedProject: null,
                activeTab: 'overview',
                investmentAmount: null,
                filters: {
                    type: '',
                    status: '',
                    city: '',
                    minBudget: '',
                    maxBudget: '',
                    minROI: '',
                    maxROI: '',
                    minDuration: '',
                    maxDuration: ''
                },
                projects: [
                    {
                        id: 1,
                        title: "Les Palmiers Residence - Yaoundé",
                        type: "Residential",
                        location: "Bastos, Yaoundé",
                        image: "/api/placeholder/400/300",
                        status: "funding",
                        expectedROI: 14.5,
                        duration: 24,
                        fundingProgress: 73,
                        raisedAmount: 1825000,
                        targetAmount: 2500000,
                        minInvestment: 50000,
                        rating: 4.6,
                        reviewsCount: 23,
                        isFavorite: false,
                        description: "Construction project of a high-end residence with 12 apartments in the prestigious Bastos neighborhood. Each apartment has 3 bedrooms, a modern living room and private parking.",
                        developer: {
                            name: "SARL Modern Construction",
                            experience: "15 years experience"
                        },
                        documents: [
                            { id: 1, name: "Land title", size: "2.4 MB" },
                            { id: 2, name: "Building permit", size: "1.8 MB" },
                            { id: 3, name: "Feasibility study", size: "5.2 MB" }
                        ],
                        risks: [
                            { id: 1, title: "Construction risk", level: "low", description: "Construction deadlines may be extended" },
                            { id: 2, title: "Rental risk", level: "medium", description: "Occupancy rate may vary according to the market" }
                        ],
                        updates: [
                            { id: 1, title: "Foundation work started", date: "15 Jan 2025", content: "Earthworks have begun 2 weeks ahead of the initial schedule." }
                        ]
                    },
                    {
                        id: 2,
                        title: "Bonanjo Shopping Center",
                        type: "Commercial",
                        location: "Bonanjo, Douala",
                        image: "/api/placeholder/400/300",
                        status: "funded",
                        expectedROI: 18.2,
                        duration: 36,
                        fundingProgress: 100,
                        raisedAmount: 5000000,
                        targetAmount: 5000000,
                        minInvestment: 100000,
                        rating: 4.8,
                        reviewsCount: 41,
                        isFavorite: true,
                        description: "Construction of a modern 2000m² shopping center with 24 shops, restaurant and 50-space parking lot.",
                        developer: {
                            name: "Littoral Real Estate Group",
                            experience: "22 years experience"
                        },
                        documents: [
                            { id: 1, name: "Land title", size: "2.1 MB" },
                            { id: 2, name: "Impact study", size: "3.7 MB" }
                        ],
                        risks: [
                            { id: 1, title: "Commercial risk", level: "medium", description: "Success depends on the commercial attractiveness of the area" }
                        ],
                        updates: [
                            { id: 1, title: "Opening planned for March", date: "10 Jan 2025", content: "Work is progressing well, opening planned for March 2025." }
                        ]
                    },
                    {
                        id: 3,
                        title: "Modern Villa Mendong",
                        type: "Residential",
                        location: "Mendong, Yaoundé",
                        image: "/api/placeholder/400/300",
                        status: "generating",
                        expectedROI: 12.8,
                        duration: 18,
                        fundingProgress: 100,
                        raisedAmount: 850000,
                        targetAmount: 850000,
                        minInvestment: 25000,
                        rating: 4.4,
                        reviewsCount: 17,
                        isFavorite: false,
                        description: "4-bedroom villa with swimming pool and garden, currently rented to an expatriate family.",
                        developer: {
                            name: "ABC Promotion",
                            experience: "8 years experience"
                        },
                        documents: [
                            { id: 1, name: "Lease agreement", size: "1.2 MB" }
                        ],
                        risks: [
                            { id: 1, title: "Tenant risk", level: "low", description: "Risk of tenant change" }
                        ],
                        updates: [
                            { id: 1, title: "January revenues distributed", date: "5 Feb 2025", content: "January revenues have been distributed to investors." }
                        ]
                    }
                ],
                filteredProjects: [],

                init() {
                    this.filteredProjects = this.projects;
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('en-US').format(amount);
                },

                getStatusText(status) {
                    const statusMap = {
                        'funding': 'Funding in Progress',
                        'funded': 'Funded',
                        'generating': 'Generating Income'
                    };
                    return statusMap[status] || status;
                },

                applyFilters() {
                    this.filteredProjects = this.projects.filter(project => {
                        return (!this.filters.type || project.type.toLowerCase().includes(this.filters.type)) &&
                               (!this.filters.status || project.status === this.filters.status) &&
                               (!this.filters.city || project.location.toLowerCase().includes(this.filters.city)) &&
                               (!this.filters.minBudget || project.minInvestment >= parseInt(this.filters.minBudget)) &&
                               (!this.filters.maxBudget || project.minInvestment <= parseInt(this.filters.maxBudget)) &&
                               (!this.filters.minROI || project.expectedROI >= parseFloat(this.filters.minROI)) &&
                               (!this.filters.maxROI || project.expectedROI <= parseFloat(this.filters.maxROI));
                    });
                },

                searchProjects() {
                    if (!this.searchQuery) {
                        this.applyFilters();
                        return;
                    }
                    this.filteredProjects = this.projects.filter(project =>
                        project.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        project.location.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        project.type.toLowerCase().includes(this.searchQuery.toLowerCase())
                    );
                },

                resetFilters() {
                    this.filters = {
                        type: '',
                        status: '',
                        city: '',
                        minBudget: '',
                        maxBudget: '',
                        minROI: '',
                        maxROI: '',
                        minDuration: '',
                        maxDuration: ''
                    };
                    this.searchQuery = '';
                    this.filteredProjects = this.projects;
                },

                toggleFavorite(projectId) {
                    const project = this.projects.find(p => p.id === projectId);
                    if (project) {
                        project.isFavorite = !project.isFavorite;
                    }
                },

                openProjectModal(project) {
                    this.selectedProject = project;
                    this.showModal = true;
                    this.activeTab = 'overview';
                    this.investmentAmount = project.minInvestment;
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.showModal = false;
                    this.selectedProject = null;
                    document.body.style.overflow = 'auto';
                },

                quickInvest(project) {
                    this.openProjectModal(project);
                },

                calculateShares() {
                    if (!this.investmentAmount || !this.selectedProject) return 0;
                    return Math.floor(this.investmentAmount / (this.selectedProject.targetAmount / 1000));
                },

                calculateMonthlyReturn() {
                    if (!this.investmentAmount || !this.selectedProject) return 0;
                    const monthlyROI = this.selectedProject.expectedROI / 12 / 100;
                    return Math.round(this.investmentAmount * monthlyROI);
                },

                proceedToInvestment() {
                    if (this.investmentAmount && this.investmentAmount >= this.selectedProject.minInvestment) {
                        alert('Redirecting to payment process for ' + this.formatCurrency(this.investmentAmount) + ' FCFA');
                        // Here, redirect to payment page
                    }
                }
            }
        }