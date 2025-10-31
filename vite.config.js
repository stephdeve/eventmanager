import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     host: '0.0.0.0',      // écoute toutes les connexions réseau
    //     port: 5173,           // port Vite
    //     hmr: {
    //         host: '192.168.100.7', // ton IP locale actuelle (à vérifier)
    //     },
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
