require('./bootstrap');

// Import modules...
import AppLayout from "@/Layouts/AppLayout";
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import mitt from 'mitt';
import { createApp, h } from 'vue';
const emitter = mitt()



const el = document.getElementById('app');

createApp({
        render: () =>
            h(InertiaApp, {
                initialPage: JSON.parse(el.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            }),
    })
    .component('AppLayout', AppLayout)
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(emitter)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });