// Exemple : smooth scroll pour les ancres
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e){
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if(target){
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// Exemple : toggle mobile menu
const btn = document.querySelector('#mobile-menu-btn');
const menu = document.querySelector('#mobile-menu');

btn?.addEventListener('click', () => {
    menu?.classList.toggle('hidden');
});
