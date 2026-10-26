<script setup>
import { useCountUp } from '@/Components/Admin/Dashboard/helpers';
import Icon from '@/Components/Icon.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

// Stat tile. Props are backward compatible with the old coloured SmallBox
// (value, label, icon, color, href); `hint` adds a small line under the label.
const props = defineProps({
    value: [String, Number],
    label: String,
    icon: { type: String, default: 'sparkles' },
    color: { type: String, default: 'info' }, // info | success | warning | danger | violet | cyan | indigo | slate
    href: { type: String, default: null },
    hint: { type: String, default: '' },
});

const chip = {
    info: 'from-sky-500 to-blue-600 shadow-sky-500/30',
    success: 'from-emerald-500 to-teal-500 shadow-emerald-500/30',
    warning: 'from-amber-400 to-orange-500 shadow-amber-500/30',
    danger: 'from-rose-500 to-pink-600 shadow-rose-500/30',
    violet: 'from-violet-500 to-fuchsia-500 shadow-violet-500/30',
    cyan: 'from-cyan-400 to-sky-500 shadow-cyan-500/30',
    indigo: 'from-indigo-500 to-blue-500 shadow-indigo-500/30',
    slate: 'from-slate-600 to-slate-800 shadow-slate-500/30',
};

const glow = {
    info: 'bg-sky-400/15',
    success: 'bg-emerald-400/15',
    warning: 'bg-amber-400/20',
    danger: 'bg-rose-400/15',
    violet: 'bg-violet-400/15',
    cyan: 'bg-cyan-400/15',
    indigo: 'bg-indigo-400/15',
    slate: 'bg-slate-400/15',
};

const isNumber = computed(() => props.value !== null && props.value !== undefined && props.value !== '' && !Number.isNaN(Number(props.value)));
const counted = useCountUp(() => (isNumber.value ? Number(props.value) : 0));
const shown = computed(() => (isNumber.value ? counted.value.toLocaleString('en-US') : (props.value ?? '—')));
</script>

<template>
    <component
        :is="href ? Link : 'div'"
        :href="href || undefined"
        class="group relative flex min-h-[88px] items-center gap-4 overflow-hidden rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition duration-300"
        :class="href ? 'hover:-translate-y-1 hover:border-slate-300 hover:shadow-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-accent-500' : ''"
        :aria-label="`${label}: ${value ?? 0}`"
    >
        <span class="pointer-events-none absolute -right-6 -top-6 h-24 w-24 rounded-full blur-xl transition duration-500 group-hover:scale-150" :class="glow[color] ?? glow.info" />
        <span
            class="relative flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br text-white shadow-lg transition duration-300 group-hover:scale-110 group-hover:-rotate-3"
            :class="chip[color] ?? chip.info"
        >
            <Icon :name="icon" class="h-6 w-6" />
        </span>
        <span class="relative min-w-0">
            <span class="block text-2xl font-extrabold leading-none tracking-tight text-slate-800 sm:text-3xl">{{ shown }}</span>
            <span class="mt-1 block truncate text-sm font-medium text-slate-500">{{ label }}</span>
            <span v-if="hint" class="mt-0.5 block truncate text-xs text-slate-400">{{ hint }}</span>
        </span>
        <Icon v-if="href" name="chevron-right" class="absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-300 opacity-0 transition group-hover:translate-x-0.5 group-hover:opacity-100" />
    </component>
</template>
