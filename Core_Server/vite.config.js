import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import monacoEditorPlugin from 'vite-plugin-monaco-editor';

export default defineConfig({
    server: {
        host: 'localhost',
        port: 5173,
        proxy: {
            // Proxy all requests except for Vite assets to Laravel
            '^/(?!@vite|resources|node_modules|vite).*': {
                target: 'http://localhost:8000',
                changeOrigin: true,
                secure: false,
            },
        },
    },
    plugins: [
        tailwindcss(),
        monacoEditorPlugin,
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
