import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
// Expose Pusher globally and enable console logs for debugging (also used by Reverb)
window.Pusher = Pusher;
try { window.Pusher.logToConsole = true; } catch (_) {}
const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
const CSRF = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

// Prefer Reverb if configured, otherwise fallback to Pusher
if (import.meta.env.VITE_REVERB_APP_KEY) {
    const host = import.meta.env.VITE_REVERB_HOST ?? (window.location.hostname || '127.0.0.1');
    const port = Number(import.meta.env.VITE_REVERB_PORT ?? 8080);
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: host,
        wsPort: port,
        wssPort: port,
        forceTLS: false,
        encrypted: false,
        enabledTransports: ['ws'],
        disabledTransports: ['wss'],
        authEndpoint: '/broadcasting/auth',
        withCredentials: true,
        auth: {
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
        },
    });
} else if (import.meta.env.VITE_PUSHER_APP_KEY) {
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'eu',
        wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
        wsPort: Number(import.meta.env.VITE_PUSHER_PORT ?? 80),
        wssPort: Number(import.meta.env.VITE_PUSHER_PORT ?? 443),
        forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        withCredentials: true,
        auth: {
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
        },
    });
}
