// Dropdown utilisateur
const userMenuButton = document.getElementById('userMenuButton');
const userDropdown = document.getElementById('userDropdown');

if(userMenuButton){
    userMenuButton.addEventListener('click', () => {
        userDropdown.classList.toggle('hidden');
    });

    // Fermer dropdown si clic à l'extérieur
    window.addEventListener('click', (e) => {
        if(!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)){
            userDropdown.classList.add('hidden');
        }
    });
}

// Menu mobile
const mobileMenuButton = document.getElementById('mobileMenuButton');
const mobileMenu = document.getElementById('mobileMenu');

mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});
