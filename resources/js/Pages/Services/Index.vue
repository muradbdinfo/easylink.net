<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    services: Array,
});

const { c, list } = useContent();

// Card accent colours cycle so the grid feels lively; purely visual.
const tones = [
    'from-brand-600 to-accent-500',
    'from-violet-600 to-fuchsia-500',
    'from-emerald-600 to-teal-500',
    'from-amber-500 to-orange-500',
    'from-rose-600 to-pink-500',
    'from-indigo-600 to-brand-500',
];

const isExternal = (url) => /^(https?:)?\/\//.test(url) || url?.startsWith('mailto:') || url?.startsWith('tel:');
</script>

<template>
    <Head :title="c('services.hero.title', 'Services')" />

    <PublicLayout>
        <PageHero page-key="services" />

        <!-- Cards -->
        <section class="relative overflow-hidden bg-gradient-to-b from-white via-slate-50 to-white py-20">
            <div class="pointer-events-none absolute -left-24 top-24 h-80 w-80 rounded-full bg-accent-300/20 blur-3xl" />
            <div class="pointer-events-none absolute -right-24 bottom-24 h-80 w-80 rounded-full bg-violet-300/20 blur-3xl" />
            <div class="container-x relative">
                <div v-if="c('services.list.heading') || c('services.list.subheading')" class="mx-auto max-w-2xl text-center">
                    <h2 v-if="c('services.list.heading')" class="section-title">{{ c('services.list.heading') }}</h2>
                    <p v-if="c('services.list.subheading')" class="section-subtitle">{{ c('services.list.subheading') }}</p>
                </div>

                <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="(service, i) in services"
                        :key="service.id"
                        :href="route('services.show', service.slug)"
                        class="card group relative flex flex-col overflow-hidden p-7 transition duration-300 hover:-translate-y-1.5 hover:border-transparent hover:shadow-2xl"
                    >
                        <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r opacity-0 transition group-hover:opacity-100" :class="tones[i % tones.length]" />
                        <span class="pointer-events-none absolute -right-8 -top-8 h-28 w-28 rounded-full bg-gradient-to-br opacity-10 transition duration-500 group-hover:scale-150 group-hover:opacity-20" :class="tones[i % tones.length]" />
                        <span class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br text-white shadow-lg transition duration-300 group-hover:rotate-3 group-hover:scale-110" :class="tones[i % tones.length]">
                            <Icon :name="service.icon" class="h-7 w-7" />
                        </span>
                        <h3 class="relative mt-5 text-lg font-bold text-brand-900">{{ service.title }}</h3>
                        <p class="relative mt-2 flex-1 text-sm leading-relaxed text-slate-500">{{ service.short_description }}</p>
                        <span class="relative mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-accent-600">
                            {{ c('services.card.cta', 'Learn more') }}
                            <Icon name="chevron-right" class="h-4 w-4 transition group-hover:translate-x-1" />
                        </span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Why choose us -->
        <section v-if="list('services.why.items').length" class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-[#1e1b6b] to-violet-900 py-20 text-white">
            <div v-if="c('services.why.image')" class="absolute inset-0 bg-cover bg-center opacity-40" :style="{ backgroundImage: `url('${c('services.why.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900 via-brand-900/85 to-brand-900/60" />
            <div class="grid-bg absolute inset-0 opacity-30 [mask-image:radial-gradient(ellipse_at_center,black,transparent_75%)]" />
            <div class="container-x relative">
                <h2 v-if="c('services.why.title')" class="mx-auto max-w-2xl text-center text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('services.why.title') }}</h2>
                <div class="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="(item, i) in list('services.why.items')" :key="i" class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur transition hover:-translate-y-1 hover:bg-white/15">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-accent-300 ring-1 ring-white/20">
                            <Icon :name="item.icon" class="h-6 w-6" />
                        </span>
                        <p class="mt-4 text-lg font-bold">{{ item.title }}</p>
                        <p class="mt-1 text-sm text-slate-300">{{ item.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA band -->
        <section class="relative overflow-hidden py-20 text-white">
            <div v-if="c('services.cta.image')" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('services.cta.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900/95 via-brand-900/80 to-brand-800/60" />
            <div class="container-x relative flex flex-col items-center gap-8 text-center lg:flex-row lg:justify-between lg:text-left">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('services.cta.title') }}</h2>
                    <p class="mt-3 text-lg text-slate-200">{{ c('services.cta.text') }}</p>
                </div>
                <div class="flex flex-wrap justify-center gap-3">
                    <component :is="isExternal(c('services.cta.button_url')) ? 'a' : Link" v-if="c('services.cta.button')" :href="c('services.cta.button_url')" class="btn-primary">{{ c('services.cta.button') }}</component>
                    <component :is="isExternal(c('services.cta.button2_url')) ? 'a' : Link" v-if="c('services.cta.button2')" :href="c('services.cta.button2_url')" class="btn-outline">{{ c('services.cta.button2') }}</component>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
