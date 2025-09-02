// Optional: Admin sidebar toggle
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if(sidebar) sidebar.classList.toggle('hidden');
}

// Optional: Action buttons for project management
document.querySelectorAll('button').forEach(btn => {
    btn.addEventListener('click', (e) => {
        // Add modal open or API calls here
        console.log('Button clicked:', e.currentTarget);
    });
});
