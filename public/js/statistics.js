// public/js/statistics.js

// 1. User Activity Chart
const ctxUser = document.getElementById('userActivityChart').getContext('2d');
new Chart(ctxUser, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Active Users',
            data: [50, 75, 150, 100, 200, 250],
            borderColor: '#1d4ed8',
            backgroundColor: 'rgba(29, 78, 216, 0.1)',
            fill: true
        }]
    }
});

// 2. Property Distribution Chart
const ctxProperty = document.getElementById('propertyDistributionChart').getContext('2d');
new Chart(ctxProperty, {
    type: 'doughnut',
    data: {
        labels: ['Apartments', 'Houses', 'Lands'],
        datasets: [{
            label: 'Distribution',
            data: [45, 30, 25],
            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b']
        }]
    }
});

// 3. Monthly Transactions Chart
const ctxTransactions = document.getElementById('monthlyTransactionsChart').getContext('2d');
new Chart(ctxTransactions, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Transactions',
            data: [120, 190, 300, 250, 400, 500],
            backgroundColor: '#8b5cf6'
        }]
    }
});
