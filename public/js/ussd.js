// Exemple: récupérer la valeur entrée et afficher dans console
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.querySelector('.ussd-btn');
    const input = document.querySelector('.ussd-input input');

    btn.addEventListener('click', function() {
        const value = input.value.trim();
        if(value) {
            console.log('Choix USSD:', value);
            alert(`Vous avez choisi: ${value}`);
        } else {
            alert('Veuillez entrer un choix valide.');
        }
    });
});
