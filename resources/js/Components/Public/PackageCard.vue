<script setup>
import Icon from '@/Components/Icon.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    pkg: { type: Object, required: true },
});

const formatPrice = (value) => Number(value).toLocaleString('en-US', { maximumFractionDigits: 0 });
</script>

<template>
    <div
        class="relative flex flex-col rounded-3xl border p-7 transition duration-200 hover:-translate-y-1 hover:shadow-xl"
        :class="
            pkg.is_popular
                ? 'border-transparent bg-brand-900 text-white shadow-xl shadow-accent-500/20 ring-2 ring-accent-500'
                : 'border-slate-200 bg-white text-slate-600 shadow-sm'
        "
    >
        <span
            v-if="pkg.is_popular"
            class="absolute -top-3 left-7 rounded-full bg-accent-500 px-3 py-1 text-xs font-semibold text-white shadow"
        >
            Most popular
        </span>

        <h3 class="text-lg font-bold" :class="pkg.is_popular ? 'text-white' : 'text-brand-900'">{{ pkg.name }}</h3>

        <div class="mt-4 flex items-end gap-1.5">
            <span class="text-5xl font-extrabold leading-none tracking-tight" :class="pkg.is_popular ? 'text-white' : 'text-brand-900'">{{ pkg.speed_mbps }}</span>
            <span class="pb-1 text-sm font-medium" :class="pkg.is_popular ? 'text-brand-300' : 'text-slate-500'">
                Mbps · {{ pkg.type === 'corporate' ? 'Dedicated' : 'Unlimited' }}
            </span>
        </div>

        <div class="mt-5 flex items-baseline gap-1.5 border-t pt-5" :class="pkg.is_popular ? 'border-white/10' : 'border-slate-100'">
            <span class="text-2xl font-bold" :class="pkg.is_popular ? 'text-accent-300' : 'text-accent-600'">৳{{ formatPrice(pkg.price) }}</span>
            <span class="text-xs" :class="pkg.is_popular ? 'text-slate-400' : 'text-slate-500'">{{ pkg.price_note }}</span>
        </div>

        <ul class="mt-6 flex-1 space-y-3 text-sm">
            <li v-for="feature in pkg.features" :key="feature" class="flex items-start gap-2.5">
                <Icon name="check" class="mt-0.5 h-5 w-5 shrink-0" :class="pkg.is_popular ? 'text-brand-300' : 'text-brand-500'" />
                {{ feature }}
            </li>
        </ul>

        <Link
            :href="route('contact.index', { package_id: pkg.id, type: 'package' })"
            class="mt-8 w-full text-center"
            :class="pkg.is_popular ? 'btn-primary' : 'btn-secondary'"
        >
            Order now
        </Link>
    </div>
</template>
