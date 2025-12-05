import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
const CSRF = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

// Prefer Reverb if configured, otherwise fallback to Pusher
if (import.meta.env.VITE_REVERB_APP_KEY) {
    const reverbScheme = (import.meta.env.VITE_REVERB_SCHEME ?? 'https');
    const isSecure = reverbScheme === 'https';
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST ?? (window.location.hostname || '127.0.0.1'),
        wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? (isSecure ? 443 : 80)),
        wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 443),
        forceTLS: isSecure,
        enabledTransports: isSecure ? ['wss'] : ['ws'],
        disabledTransports: isSecure ? [] : ['wss'],
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
