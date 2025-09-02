// Notifications (Pusher example)
Echo.channel('wallet.' + userId)
    .listen('WalletUpdated', (e) => {
        alert(`Wallet updated: ${e.amount} FCFA`);
    });
import Echo from 'laravel-echo';