<script setup>
import Icon from '@/Components/Icon.vue';
import { useContent } from '@/composables/useContent';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    pkg: { type: Object, required: true },
});

const { c } = useContent();

const formatPrice = (value) => Number(value).toLocaleString('en-US', { maximumFractionDigits: 0 });

// Photo on top of every card — cycles through the six default hero pictures.
const photos = ['woman-kitchen-phone', 'mother-son-sofa', 'team-laptop', 'couple-tablet', 'mother-daughter-laptop', 'woman-phone-laptop'];
const photo = `/images/stock/${photos[Math.abs(Number(props.pkg.id) || 0) % photos.length]}.jpg`;
</script>

<template>
    <div
        class="group relative flex flex-col overflow-hidden rounded-xl border bg-white transition duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-900/10"
        :class="pkg.is_popular ? 'border-accent-500 shadow-xl shadow-accent-500/10' : 'border-slate-200 shadow-sm'"
    >
        <!-- photo header with name and the red speed badge -->
        <div class="relative h-56 overflow-hidden bg-brand-900">
            <img :src="photo" :alt="pkg.name" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" />
            <span class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/10 to-transparent" />

            <span
                v-if="pkg.is_popular"
                class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1 text-xs font-medium uppercase tracking-wide text-accent-600 shadow"
            >
                <Icon name="star" class="h-3.5 w-3.5 fill-current" />
                {{ c('packages.card.popular_badge', 'Most popular') }}
            </span>

            <h3 class="absolute bottom-4 left-6 right-32 font-display text-xl text-white">{{ pkg.name }}</h3>

            <div class="absolute bottom-0 right-0 flex min-w-[7.5rem] flex-col items-center bg-accent-600 px-5 py-4 text-white">
                <span class="text-3xl font-semibold leading-none">{{ pkg.speed_mbps }}</span>
                <span class="mt-1 text-xs font-medium">Mbps</span>
            </div>
        </div>

        <div class="flex flex-1 flex-col px-7 pb-7 pt-6">
            <ul class="flex-1 space-y-3 text-sm text-slate-700">
                <li v-for="feature in pkg.features" :key="feature" class="flex items-start gap-3">
                    <Icon name="check" class="mt-0.5 h-4 w-4 shrink-0 rounded-sm border border-accent-500 p-px text-accent-500" />
                    {{ feature }}
                </li>
            </ul>

            <div class="mt-6">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-800">
                    {{ pkg.type === 'corporate' ? c('packages.card.unit_corporate', 'Dedicated') : c('packages.card.unit_home', 'Unlimited') }}<template v-if="!/from/i.test(pkg.price_note || '')"> · Start from</template>
                </p>
                <p class="mt-1 flex items-baseline gap-1.5">
                    <span class="text-4xl font-medium text-accent-600">৳{{ formatPrice(pkg.price) }}</span>
                    <span class="text-xs uppercase text-slate-700">{{ pkg.price_note }}</span>
                </p>
            </div>

            <Link :href="route('contact.index', { package_id: pkg.id, type: 'package' })" class="btn-primary mt-6 self-start !px-6 !py-3">
                {{ c('packages.card.order_button', 'Order now') }}
                <Icon name="chevron-right" class="h-4 w-4" />
            </Link>
        </div>
    </div>
</template>
