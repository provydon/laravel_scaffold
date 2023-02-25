<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'nav-link active'
        : 'nav-link';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
