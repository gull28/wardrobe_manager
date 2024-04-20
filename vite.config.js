import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
        input: ['public/app.css','resources/scss/app.scss', 'public/app.js'],
            refresh: true,
        }),
    ],
});
