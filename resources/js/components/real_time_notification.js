Echo.private(`user.${userId}`)
    .notification((notification) => {
        // Update frontend notifications dynamically
        console.log(notification);
        alert(notification.message);
    });
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');