// import './bootstrap';
import { createInertiaApp } from '@inertiajs/inertia-svelte'
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import "../less/app.less";
import Layout from "../svelte/Base/Layout.svelte";

async function resolve(name)
{
    let component;
    const pagesWithoutLayout = [
        'Session/Index',
    ];
    const page = resolvePageComponent(`../svelte/Pages/${name}.svelte`, import.meta.glob('../svelte/Pages/**/*.svelte'));
    await page
        .then(module => {
            component = pagesWithoutLayout.includes(name) ?
                module :
                Object.assign({ layout: Layout }, module);
        });
    return component;
}

createInertiaApp({
    resolve,
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
});