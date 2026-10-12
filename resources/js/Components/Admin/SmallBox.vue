<script setup>
import Icon from '@/Components/Icon.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    value: [String, Number],
    label: String,
    icon: { type: String, default: 'sparkles' },
    color: { type: String, default: 'info' }, // info | success | warning | danger
    href: { type: String, default: null },
});

const colorClasses = {
    info: 'bg-sky-500',
    success: 'bg-emerald-500',
    warning: 'bg-amber-500',
    danger: 'bg-rose-500',
};
</script>

<template>
    <div class="relative overflow-hidden rounded-md text-white shadow-sm" :class="colorClasses[color] ?? colorClasses.info">
        <div class="relative z-10 px-4 pb-3 pt-4">
            <p class="text-3xl font-bold">{{ value }}</p>
            <p class="text-sm opacity-90">{{ label }}</p>
        </div>
        <Icon :name="icon" class="pointer-events-none absolute -bottom-3 -right-3 h-20 w-20 text-white/20" />
        <Link v-if="href" :href="href" class="relative z-10 block bg-black/10 px-4 py-1.5 text-center text-xs font-medium hover:bg-black/20">
            View details <span aria-hidden="true">→</span>
        </Link>
    </div>
</template>
