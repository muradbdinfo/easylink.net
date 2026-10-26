<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import { computed, ref } from 'vue';

// Messages (area) and quote requests (line) per day. Pure SVG, scales with its container via viewBox.
const props = defineProps({
    trend: { type: Array, default: () => [] }, // [{date, label, messages, quotes}]
});

const uid = `ac${Math.random().toString(36).slice(2, 8)}`;
const W = 640;
const H = 240;
const PL = 34;
const PR = 14;
const PT = 16;
const PB = 28;

const range = ref(30);
const hover = ref(null);
const svgEl = ref(null);

const data = computed(() => props.trend.slice(-range.value));
const total = computed(() => data.value.reduce((s, d) => s + (d.messages || 0), 0));
const totalQuotes = computed(() => data.value.reduce((s, d) => s + (d.quotes || 0), 0));
const peak = computed(() => data.value.reduce((best, d) => ((d.messages || 0) > (best?.messages || 0) ? d : best), null));

const max = computed(() => {
    const m = Math.max(0, ...data.value.map((d) => Math.max(d.messages || 0, d.quotes || 0)));
    return Math.max(4, Math.ceil(m / 2) * 2);
});

const innerW = W - PL - PR;
const innerH = H - PT - PB;
const x = (i) => PL + (data.value.length <= 1 ? innerW / 2 : (i * innerW) / (data.value.length - 1));
const y = (v) => PT + innerH * (1 - v / max.value);

const smooth = (key) => {
    const pts = data.value.map((d, i) => [x(i), y(d[key] || 0)]);
    if (!pts.length) return '';
    let path = `M${pts[0][0]},${pts[0][1]}`;
    for (let i = 1; i < pts.length; i++) {
        const cx = (pts[i - 1][0] + pts[i][0]) / 2;
        path += ` C${cx},${pts[i - 1][1]} ${cx},${pts[i][1]} ${pts[i][0]},${pts[i][1]}`;
    }
    return path;
};

const messagesLine = computed(() => smooth('messages'));
const quotesLine = computed(() => smooth('quotes'));
const area = computed(() => (data.value.length ? `${messagesLine.value} L${x(data.value.length - 1)},${y(0)} L${x(0)},${y(0)} Z` : ''));

const ticks = computed(() => [0, max.value / 2, max.value].map((v) => ({ v, y: y(v) })));
const xLabels = computed(() => {
    const n = data.value.length;
    const step = range.value <= 7 ? 1 : 5;
    return data.value
        .map((d, i) => ({ i, label: d.label || d.date, x: x(i) }))
        .filter(({ i }) => i % step === 0 || i === n - 1)
        .filter(({ i }) => !(i !== n - 1 && n - 1 - i < step && step > 1));
});

const onMove = (e) => {
    const rect = svgEl.value?.getBoundingClientRect();
    if (!rect || !data.value.length) return;
    const px = ((e.clientX - rect.left) / rect.width) * W;
    const i = Math.round(((px - PL) / innerW) * (data.value.length - 1));
    hover.value = Math.min(data.value.length - 1, Math.max(0, i));
};

const tip = computed(() => {
    if (hover.value === null || !data.value[hover.value]) return null;
    const d = data.value[hover.value];
    const left = (x(hover.value) / W) * 100;
    return { d, left: Math.min(88, Math.max(12, left)), px: x(hover.value) / W * 100 };
});

const summary = computed(
    () =>
        `Messages in the last ${range.value} days: ${total.value} total, ${totalQuotes.value} of them quote requests.` +
        (peak.value && peak.value.messages ? ` Busiest day: ${peak.value.label || peak.value.date} with ${peak.value.messages}.` : ''),
);
</script>

<template>
    <AdminCard title="Messages overview" accent="accent">
        <template #tools>
            <div class="flex rounded-md bg-slate-100 p-0.5" role="group" aria-label="Chart range">
                <button
                    v-for="r in [7, 30]"
                    :key="r"
                    type="button"
                    class="min-h-[32px] rounded px-3 text-xs font-semibold transition"
                    :class="range === r ? 'bg-white text-brand-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                    :aria-pressed="range === r"
                    @click="range = r"
                >
                    {{ r }} days
                </button>
            </div>
        </template>

        <div class="p-4 sm:p-5">
            <div class="flex flex-wrap items-end justify-between gap-x-6 gap-y-2">
                <div>
                    <p class="text-3xl font-extrabold leading-none text-slate-800">{{ total }}</p>
                    <p class="mt-1 text-xs text-slate-400">messages in the last {{ range }} days</p>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-brand-500" />Messages {{ total }}</span>
                    <span class="flex items-center gap-1.5"><span class="h-0.5 w-4 rounded bg-amber-500" />Quote requests {{ totalQuotes }}</span>
                </div>
            </div>

            <div class="relative mt-4" @pointerleave="hover = null">
                <svg
                    ref="svgEl"
                    :viewBox="`0 0 ${W} ${H}`"
                    class="block h-auto w-full touch-pan-y select-none"
                    role="img"
                    :aria-label="summary"
                    @pointermove="onMove"
                    @pointerdown="onMove"
                >
                    <defs>
                        <linearGradient :id="`${uid}-fill`" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#2f7bf0" stop-opacity="0.35" />
                            <stop offset="100%" stop-color="#2f7bf0" stop-opacity="0.02" />
                        </linearGradient>
                        <linearGradient :id="`${uid}-line`" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%" stop-color="#0891e0" />
                            <stop offset="100%" stop-color="#2f7bf0" />
                        </linearGradient>
                    </defs>

                    <g v-for="t in ticks" :key="t.v">
                        <line :x1="PL" :x2="W - PR" :y1="t.y" :y2="t.y" stroke="#e2e8f0" stroke-dasharray="3 4" />
                        <text :x="PL - 8" :y="t.y + 4" text-anchor="end" font-size="11" fill="#94a3b8">{{ t.v }}</text>
                    </g>
                    <text
                        v-for="l in xLabels"
                        :key="l.i"
                        :x="l.x"
                        :y="H - 8"
                        :text-anchor="l.i === 0 ? 'start' : l.i === data.length - 1 ? 'end' : 'middle'"
                        font-size="11"
                        fill="#94a3b8"
                    >{{ l.label }}</text>

                    <path v-if="area" :d="area" :fill="`url(#${uid}-fill)`" />
                    <path v-if="messagesLine" :d="messagesLine" fill="none" :stroke="`url(#${uid}-line)`" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path v-if="quotesLine && totalQuotes" :d="quotesLine" fill="none" stroke="#f59e0b" stroke-width="2" stroke-dasharray="5 4" stroke-linecap="round" />

                    <g v-if="tip">
                        <line :x1="x(hover)" :x2="x(hover)" :y1="PT" :y2="H - PB" stroke="#94a3b8" stroke-dasharray="3 3" />
                        <circle :cx="x(hover)" :cy="y(tip.d.messages || 0)" r="5" fill="#fff" stroke="#2f7bf0" stroke-width="2.5" />
                        <circle v-if="totalQuotes" :cx="x(hover)" :cy="y(tip.d.quotes || 0)" r="4" fill="#fff" stroke="#f59e0b" stroke-width="2" />
                    </g>
                </svg>

                <div
                    v-if="tip"
                    class="pointer-events-none absolute top-0 z-10 -translate-x-1/2 rounded-lg bg-slate-900 px-3 py-2 text-xs text-white shadow-xl"
                    :style="{ left: `${tip.left}%` }"
                >
                    <p class="font-semibold">{{ tip.d.label || tip.d.date }}</p>
                    <p class="mt-1 flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-brand-400" />Messages: <strong>{{ tip.d.messages || 0 }}</strong></p>
                    <p class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-amber-400" />Quotes: <strong>{{ tip.d.quotes || 0 }}</strong></p>
                </div>

                <p v-if="!total" class="pointer-events-none absolute inset-0 flex items-center justify-center text-sm text-slate-400">No messages in the last {{ range }} days yet.</p>
            </div>
            <p class="sr-only">{{ summary }}</p>
        </div>
    </AdminCard>
</template>
