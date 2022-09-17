import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from "@sveltejs/vite-plugin-svelte";
import sveltePreprocess from "svelte-preprocess";

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: [
                'resources/**',
            ],
        }),
        svelte({
            preprocess: [
                sveltePreprocess({typescript: true}),
            ],
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
