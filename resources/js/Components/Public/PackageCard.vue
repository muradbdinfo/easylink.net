<script setup>
import Icon from '@/Components/Icon.vue';
import { useContent } from '@/composables/useContent';
import { Link } from '@inertiajs/vue3';

defineProps({
    pkg: { type: Object, required: true },
});

const { c } = useContent();

const formatPrice = (value) => Number(value).toLocaleString('en-US', { maximumFractionDigits: 0 });
</script>

<template>
    <div
        class="group relative flex flex-col overflow-hidden rounded-3xl border p-7 transition duration-300 hover:-translate-y-1.5 hover:shadow-2xl"
        :class="
            pkg.is_popular
                ? 'border-transparent bg-gradient-to-br from-brand-900 via-brand-800 to-brand-700 text-white shadow-xl shadow-accent-500/20 ring-2 ring-accent-500'
                : 'border-slate-200 bg-white/90 text-slate-600 shadow-sm backdrop-blur hover:border-brand-300'
        "
    >
        <!-- decorative glow -->
        <span
            class="pointer-events-none absolute -right-12 -top-12 h-36 w-36 rounded-full blur-2xl transition duration-500 group-hover:scale-125"
            :class="pkg.is_popular ? 'bg-accent-500/30' : 'bg-brand-100'"
        />

        <span
            v-if="pkg.is_popular"
            class="absolute -top-px right-6 inline-flex items-center gap-1.5 rounded-b-xl bg-accent-500 px-3 py-1.5 text-xs font-semibold text-white shadow"
        >
            <Icon name="star" class="h-3.5 w-3.5 fill-current" />
            {{ c('packages.card.popular_badge', 'Most popular') }}
        </span>

        <div class="relative flex items-center gap-3">
            <span
                class="flex h-11 w-11 items-center justify-center rounded-2xl"
                :class="pkg.is_popular ? 'bg-white/15 text-white ring-1 ring-white/25' : 'bg-brand-50 text-brand-600'"
            >
                <Icon :name="pkg.type === 'corporate' ? 'building-office' : 'wifi'" class="h-6 w-6" />
            </span>
            <h3 class="text-lg font-bold" :class="pkg.is_popular ? 'text-white' : 'text-brand-900'">{{ pkg.name }}</h3>
        </div>

        <div class="relative mt-5 flex items-end gap-1.5">
            <span class="text-5xl font-extrabold leading-none tracking-tight" :class="pkg.is_popular ? 'text-white' : 'text-brand-900'">{{ pkg.speed_mbps }}</span>
            <span class="pb-1 text-sm font-medium" :class="pkg.is_popular ? 'text-brand-300' : 'text-slate-500'">
                Mbps · {{ pkg.type === 'corporate' ? c('packages.card.unit_corporate', 'Dedicated') : c('packages.card.unit_home', 'Unlimited') }}
            </span>
        </div>

        <div class="relative mt-5 flex items-baseline gap-1.5 border-t pt-5" :class="pkg.is_popular ? 'border-white/10' : 'border-slate-100'">
            <span class="text-2xl font-bold" :class="pkg.is_popular ? 'text-accent-300' : 'text-accent-600'">৳{{ formatPrice(pkg.price) }}</span>
            <span class="text-xs" :class="pkg.is_popular ? 'text-slate-300' : 'text-slate-500'">{{ pkg.price_note }}</span>
        </div>

        <ul class="relative mt-6 flex-1 space-y-3 text-sm">
            <li v-for="feature in pkg.features" :key="feature" class="flex items-start gap-2.5">
                <Icon name="check" class="mt-0.5 h-5 w-5 shrink-0" :class="pkg.is_popular ? 'text-brand-300' : 'text-brand-500'" />
                {{ feature }}
            </li>
        </ul>

        <Link
            :href="route('contact.index', { package_id: pkg.id, type: 'package' })"
            class="relative mt-8 w-full text-center !py-3.5"
            :class="pkg.is_popular ? 'btn-primary' : 'btn-secondary'"
        >
            {{ c('packages.card.order_button', 'Order now') }}
            <Icon name="chevron-right" class="h-4 w-4" />
        </Link>
    </div>
</template>
