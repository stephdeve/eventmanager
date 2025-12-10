import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
// Expose Pusher globally and enable console logs for debugging (also used by Reverb)
window.Pusher = Pusher;
try { window.Pusher.logToConsole = true; } catch (_) { }
const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
const CSRF = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

// Prefer Reverb if configured, otherwise fallback to Pusher
// Pusher Cloud Configuration
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'eu',
    forceTLS: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': CSRF,
        },
    },
});
