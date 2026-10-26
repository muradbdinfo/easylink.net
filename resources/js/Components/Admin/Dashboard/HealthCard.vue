<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import { safeRoute, useCountUp } from '@/Components/Admin/Dashboard/helpers';
import Icon from '@/Components/Icon.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

// Content checklist: how complete the site is, with a link to fix each missing item.
const props = defineProps({
    items: { type: Array, default: () => [] }, // [{key, label, done, hint, route}]
});

const doneCount = computed(() => props.items.filter((i) => i.done).length);
const percent = computed(() => (props.items.length ? Math.round((doneCount.value / props.items.length) * 100) : 0));
const shownPercent = useCountUp(() => percent.value, 1000);
const ringColor = computed(() => (percent.value >= 80 ? '#10b981' : percent.value >= 50 ? '#f59e0b' : '#f43f5e'));
</script>

<template>
    <AdminCard title="Site health" accent="emerald">
        <div class="p-4 sm:p-5">
            <div class="flex items-center gap-4">
                <div class="relative h-20 w-20 shrink-0">
                    <svg viewBox="0 0 42 42" class="h-full w-full -rotate-90" role="img" :aria-label="`${percent}% of the content checklist is complete`">
                        <circle cx="21" cy="21" r="15.9155" fill="none" stroke="#f1f5f9" stroke-width="4.5" />
                        <circle
                            cx="21"
                            cy="21"
                            r="15.9155"
                            fill="none"
                            :stroke="ringColor"
                            stroke-width="4.5"
                            stroke-linecap="round"
                            :stroke-dasharray="`${percent} ${100 - percent}`"
                            class="transition-all duration-1000"
                        />
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center text-lg font-extrabold text-slate-800">{{ shownPercent }}%</span>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-700">{{ doneCount }} of {{ items.length }} steps done</p>
                    <p class="mt-0.5 text-xs text-slate-400">{{ percent >= 100 ? 'Your site content is complete. 🎉' : 'Finish the steps below to complete your site.' }}</p>
                </div>
            </div>

            <ul v-if="items.length" class="mt-4 space-y-1">
                <li v-for="i in items" :key="i.key">
                    <component
                        :is="i.done ? 'div' : Link"
                        :href="i.done ? undefined : safeRoute(i.route)"
                        class="flex min-h-[44px] items-center gap-3 rounded-lg px-2 py-2 text-sm"
                        :class="i.done ? '' : 'transition hover:bg-slate-50'"
                    >
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full" :class="i.done ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400'">
                            <Icon :name="i.done ? 'check' : 'clock'" class="h-4 w-4" />
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block truncate" :class="i.done ? 'text-slate-500 line-through decoration-slate-300' : 'font-medium text-slate-700'">{{ i.label }}</span>
                            <span v-if="!i.done && i.hint" class="block truncate text-xs text-slate-400">{{ i.hint }}</span>
                        </span>
                        <span v-if="!i.done" class="shrink-0 text-xs font-semibold text-brand-600">Fix →</span>
                    </component>
                </li>
            </ul>
            <p v-else class="mt-4 text-center text-sm text-slate-400">Checklist not available.</p>
        </div>
    </AdminCard>
</template>
