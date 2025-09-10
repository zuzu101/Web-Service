import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/client/pages/home/styles.css',
                'resources/css/client/pages/cekstatus/styles.css',
                'resources/css/auth/style.css',
            ],
            refresh: true,
        }),
    ],
});