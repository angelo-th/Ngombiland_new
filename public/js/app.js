// Scripts Livewire/AJAX pour chat, rapports, notifications
document.addEventListener('livewire:load', function () {
    Livewire.on('messageSent', message => {
        console.log('Message envoyé:', message);
    });

    Livewire.on('reportSubmitted', report => {
        console.log('Rapport soumis:', report);
    });
});
// Autres scripts globaux
// (par exemple, initialisation de plugins, gestion des événements globaux, etc.)// Already includes chat/report events
document.getElementById('ussd-send')?.addEventListener('click', () => {
    alert('USSD simulation: to be connected to backend');
});

document.getElementById('deposit-btn')?.addEventListener('click', () => {
    alert('Add funds simulation: to be connected to wallet API');
});

document.getElementById('withdraw-btn')?.addEventListener('click', () => {
    alert('Withdraw funds simulation: to be connected to wallet API');
});
// Chat admin - utilisateur
// (moved to admin_chat.js for clarity)