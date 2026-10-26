<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import { computed } from 'vue';

// Donut of message types + split bar of home/corporate packages.
const props = defineProps({
    byType: { type: Array, default: () => [] }, // [{type, label, count}]
    packagesByType: { type: Object, default: () => ({}) }, // {home, corporate}
});

const palette = { general: '#2f7bf0', quote: '#f59e0b', package: '#8b5cf6' };
const fallback = ['#14b8a6', '#ec4899', '#64748b'];
const labelFor = (type) => ({ general: 'General', quote: 'Quote', package: 'Package' })[type] ?? type;

const total = computed(() => props.byType.reduce((s, t) => s + (t.count || 0), 0));

const slices = computed(() => {
    let offset = 0;
    return props.byType.map((t, i) => {
        const pct = total.value ? ((t.count || 0) / total.value) * 100 : 0;
        const slice = {
            ...t,
            label: t.label || labelFor(t.type),
            pct,
            color: palette[t.type] ?? fallback[i % fallback.length],
            dash: `${Math.max(0, pct - (props.byType.length > 1 && pct > 0 ? 1 : 0))} ${100 - Math.max(0, pct - (props.byType.length > 1 && pct > 0 ? 1 : 0))}`,
            offset: -offset,
        };
        offset += pct;
        return slice;
    });
});

const home = computed(() => props.packagesByType?.home ?? 0);
const corporate = computed(() => props.packagesByType?.corporate ?? 0);
const pkgTotal = computed(() => home.value + corporate.value);
const homePct = computed(() => (pkgTotal.value ? (home.value / pkgTotal.value) * 100 : 0));

const summary = computed(() => (total.value ? `Message types: ${slices.value.map((s) => `${s.label} ${s.count}`).join(', ')}.` : 'No messages yet.'));
</script>

<template>
    <AdminCard title="Message types" accent="rose">
        <div class="p-4 sm:p-5">
            <div class="flex flex-col items-center gap-5 sm:flex-row lg:flex-col">
                <div class="relative h-36 w-36 shrink-0">
                    <svg viewBox="0 0 42 42" class="h-full w-full -rotate-90" role="img" :aria-label="summary">
                        <circle cx="21" cy="21" r="15.9155" fill="none" stroke="#f1f5f9" stroke-width="5" />
                        <circle
                            v-for="s in slices"
                            :key="s.type"
                            cx="21"
                            cy="21"
                            r="15.9155"
                            fill="none"
                            :stroke="s.color"
                            stroke-width="5"
                            :stroke-dasharray="s.dash"
                            :stroke-dashoffset="s.offset"
                            class="transition-all duration-700"
                        />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-extrabold leading-none text-slate-800">{{ total }}</span>
                        <span class="mt-0.5 text-[11px] uppercase tracking-wider text-slate-400">total</span>
                    </div>
                </div>

                <ul class="w-full min-w-0 space-y-2.5 text-sm">
                    <li v-for="s in slices" :key="s.type" class="flex items-center justify-between gap-3">
                        <span class="flex min-w-0 items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 shrink-0 rounded-full" :style="{ background: s.color }" /><span class="truncate">{{ s.label }}</span></span>
                        <span class="shrink-0 font-semibold text-slate-800">{{ s.count }} <span class="text-xs font-normal text-slate-400">{{ Math.round(s.pct) }}%</span></span>
                    </li>
                    <li v-if="!slices.length" class="text-center text-slate-400">No messages yet.</li>
                </ul>
            </div>

            <div class="mt-5 border-t border-slate-100 pt-4">
                <div class="flex items-center justify-between text-xs">
                    <p class="font-semibold text-slate-600">Packages</p>
                    <p class="text-slate-400">{{ pkgTotal }} total</p>
                </div>
                <div class="mt-2 flex h-3 overflow-hidden rounded-full bg-slate-100" role="img" :aria-label="`${home} home packages and ${corporate} corporate packages`">
                    <div class="bg-gradient-to-r from-sky-500 to-blue-500 transition-all duration-700" :style="{ width: `${homePct}%` }" />
                    <div class="flex-1 bg-gradient-to-r from-violet-400 to-fuchsia-500" :class="pkgTotal ? '' : 'opacity-0'" />
                </div>
                <div class="mt-2 flex justify-between text-xs text-slate-500">
                    <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-blue-500" />Home {{ home }}</span>
                    <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-fuchsia-500" />Corporate {{ corporate }}</span>
                </div>
            </div>
        </div>
    </AdminCard>
</template>
