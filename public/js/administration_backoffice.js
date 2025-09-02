// Dashboard JS
console.log("Dashboard JS loaded");

// Example: Chart.js integration for charts
document.addEventListener("DOMContentLoaded", function() {
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const userCtx = document.getElementById('userChart').getContext('2d');

    // Revenue Trend Chart
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: window.revenueLabels,
            datasets: [{
                label: 'Revenue (FCFA)',
                data: window.revenueData,
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });

    // User Growth Chart
    new Chart(userCtx, {
        type: 'bar',
        data: {
            labels: window.userLabels,
            datasets: [{
                label: 'Users',
                data: window.userData,
                backgroundColor: 'rgba(34, 197, 94, 0.7)',
                borderColor: 'rgba(34, 197, 94, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });
});
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
