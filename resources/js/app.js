require('./bootstrap');

// Import modules...
import { App as InertiaApp, Link, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { createApp, h } from 'vue';
import AppGlobalMethods from './Plugins/AppGlobalMethods';

const el = document.getElementById('app');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .component('Link', Link)
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(AppGlobalMethods)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
