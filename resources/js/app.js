// import './bootstrap';
import { createInertiaApp } from '@inertiajs/inertia-svelte'
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import "../less/app.less";
// import Layout from "../svelte/Base/Layout.svelte";

// async function resolve(name)
// {
//     const page = resolvePageComponent(`../svelte/Pages/${name}.svelte`, import.meta.glob('../svelte/Pages/**/*.svelte'));
//     let component;
//     await page
//         .then(module => {
//             module.default.layout = Layout;
//             component = module;
//         });
//     return component;
// }

createInertiaApp({
    resolve: name => resolvePageComponent(`../svelte/Pages/${name}.svelte`, import.meta.glob('../svelte/Pages/**/*.svelte')),
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
});