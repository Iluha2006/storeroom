// @ts-ignore
import {wayfinder} from '@laravel/vite-plugin-wayfinder';
// @ts-ignore
import tailwindcss from '@tailwindcss/vite';
// @ts-ignore
import react from '@vitejs/plugin-react';
// @ts-ignore
import laravel from 'laravel-vite-plugin';
// @ts-ignore
import {defineConfig} from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.tsx'],
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react({
            babel: {
                plugins: ['babel-plugin-react-compiler'],
            },
        }),
        wayfinder({
            formVariants: false,
            command: '',
        }),
        tailwindcss(),
    ],
    esbuild: {
        jsx: 'automatic',
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: '0.0.0.0',
            port: 5173,
        },
        watch: {
            usePolling: true,
        },
    },
});
