<script setup>
defineProps({
    title: { type: String, default: '' },
    accent: { type: String, default: 'brand' }, // brand | accent | emerald | rose
});

const accentClass = {
    brand: 'border-t-brand-600',
    accent: 'border-t-accent-500',
    emerald: 'border-t-emerald-500',
    rose: 'border-t-rose-500',
};
</script>

<template>
    <div class="overflow-hidden rounded-md border border-slate-200 border-t-[3px] bg-white shadow-sm" :class="accentClass[accent] ?? accentClass.brand">
        <div v-if="title || $slots.tools" class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
            <h3 class="text-sm font-semibold text-slate-700">{{ title }}</h3>
            <div class="flex items-center gap-2">
                <slot name="tools" />
            </div>
        </div>
        <div class="p-0">
            <slot />
        </div>
    </div>
</template>
