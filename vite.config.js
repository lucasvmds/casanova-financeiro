import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from "@sveltejs/vite-plugin-svelte";

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: [
                'resources/**',
            ],
        }),
        svelte({
            experimental: { prebundleSvelteLibraries: true },
        }),
    ],
    optimizeDeps: {
        include: [
            "@inertiajs/inertia",
            "@inertiajs/inertia-svelte",
            // "@inertiajs/progress",
        ],
    },
});
