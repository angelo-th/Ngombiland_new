// Fonction Alpine.js pour gérer les onglets et charts
function projectManagement() {
    return {
        activeTab: 'dashboard', // onglet actif par défaut

        init() {
            this.renderCharts();
        },

        renderCharts() {
            // Chart Fundraising Progress
            const ctx1 = document.getElementById('fundraisingChart');
            if(ctx1) {
                new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: ['Project 1', 'Project 2', 'Project 3'],
                        datasets: [{
                            label: 'Raised (M FCFA)',
                            data: [187, 325, 150],
                            backgroundColor: ['#10B981','#3B82F6','#F97316']
                        }]
                    },
                    options: { responsive: true, plugins: { legend: { display: false } } }
                });
            }

            // Chart Project Distribution
            const ctx2 = document.getElementById('projectChart');
            if(ctx2) {
                new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: ['Funded', 'In Progress', 'Pending'],
                        datasets: [{
                            data: [1,1,1],
                            backgroundColor: ['#10B981','#F59E0B','#EF4444']
                        }]
                    },
                    options: { responsive: true }
                });
            }
        }
    }
}
