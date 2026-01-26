<<<<<<< HEAD
// vite.config.ts
import { resolve } from 'path';

import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/index.tsx'],
    }),
    react(),
  ],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources/js'),
      react: resolve(__dirname, 'node_modules/react'),
      'react-dom': resolve(__dirname, 'node_modules/react-dom'),
=======

import {wayfinder} from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import {defineConfig} from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/index.tsx'],
            refresh: true,
        }),
        react(),
        wayfinder({
            formVariants: false,
            command: '',
        }),
        tailwindcss(),
    ],
    esbuild: {
        jsx: 'automatic',
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
    },
  },
  build: {
    rollupOptions: {
      external: ['react', 'react-dom'],
    },
  },
});