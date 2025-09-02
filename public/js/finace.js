
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Revenus (FCFA)',
                    data: [250000, 320000, 400000, 380000, 420000, 500000, 600000, 550000, 580000, 620000, 700000, 800000],
                    backgroundColor: 'rgba(44, 82, 130, 0.1)',
                    borderColor: 'rgba(44, 82, 130, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value/1000 + 'k';
                            }
                        }
                    }
                }
            }
        });

        // Distribution Chart
        const distCtx = document.getElementById('distributionChart').getContext('2d');
        const distChart = new Chart(distCtx, {
            type: 'doughnut',
            data: {
                labels: ['Investisseurs', 'Frais plateforme', 'Maintenance'],
                datasets: [{
                    data: [70, 20, 10],
                    backgroundColor: [
                        'rgba(44, 82, 130, 0.8)',
                        'rgba(22, 163, 74, 0.8)',
                        'rgba(234, 179, 8, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    