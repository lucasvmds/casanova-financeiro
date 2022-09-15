// import './bootstrap';
import { createInertiaApp } from '@inertiajs/inertia-svelte'
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import "../less/app.less";

createInertiaApp({
    resolve: name => resolvePageComponent(`../svelte/Pages/${name}.svelte`, import.meta.glob('../svelte/**/*.svelte')),
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
});