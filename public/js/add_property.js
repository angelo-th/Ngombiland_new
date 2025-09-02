// Toggle user menu if needed
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    if(menu) menu.classList.toggle('hidden');
}

// Optional: file preview before upload
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', (e) => {
        const fileName = e.target.files[0]?.name;
        if(fileName) console.log('Selected file:', fileName);
    });
});
