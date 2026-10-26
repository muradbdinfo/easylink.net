<script setup>
import Icon from '@/Components/Icon.vue';
import PackageCard from '@/Components/Public/PackageCard.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    services: Array,
    packages: Array,
    clients: Array,
    testimonials: Array,
});

const { c, list } = useContent();

// Internal paths go through Inertia, full URLs open as normal links.
const linkTag = (href) => (href?.startsWith('/') ? Link : 'a');
const logoSrc = (logo) => (logo.startsWith('/') || logo.startsWith('http') ? logo : `/storage/${logo}`);
</script>

<template>
    <Head :title="c('corporate.hero.title', 'Corporate solutions')" />

    <PublicLayout>
        <PageHero page-key="corporate" />

        <!-- Highlights -->
        <section class="relative z-10 -mt-10">
            <div class="container-x">
                <div class="grid grid-cols-1 gap-4 rounded-3xl border border-slate-200/70 bg-white p-5 shadow-xl shadow-slate-900/5 sm:grid-cols-2 sm:p-7 lg:grid-cols-4">
                    <div v-for="(item, i) in list('corporate.highlights.items')" :key="i" class="flex items-center gap-3">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-50 to-accent-100 text-brand-600">
                            <Icon :name="item.icon" class="h-6 w-6" />
                        </span>
                        <span class="min-w-0">
                            <span class="block text-sm font-bold leading-tight text-brand-900">{{ item.title }}</span>
                            <span class="mt-0.5 block text-xs text-slate-500">{{ item.desc }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Introduction -->
        <section class="py-20 sm:py-24">
            <div class="container-x grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div class="relative">
                    <div class="pointer-events-none absolute -bottom-6 -left-6 h-full w-full rounded-3xl bg-gradient-to-br from-brand-100 to-accent-100" />
                    <img
                        v-if="c('corporate.intro.image')"
                        :src="c('corporate.intro.image')"
                        :alt="c('corporate.intro.title')"
                        loading="lazy"
                        class="relative aspect-[4/3] w-full rounded-3xl object-cover shadow-2xl"
                    />
                    <div class="absolute -bottom-5 right-4 flex items-center gap-3 rounded-2xl bg-white px-4 py-3 text-brand-900 shadow-xl sm:right-8">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-700"><Icon name="shield-check" class="h-5 w-5" /></span>
                        <span class="text-sm font-semibold leading-tight">{{ list('corporate.highlights.items')[1]?.title }}</span>
                    </div>
                </div>
                <div>
                    <span class="eyebrow">{{ c('corporate.intro.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('corporate.intro.title') }}</h2>
                    <p class="mt-4 text-lg leading-relaxed text-slate-500">{{ c('corporate.intro.text') }}</p>
                    <ul class="mt-6 space-y-3">
                        <li v-for="(p, i) in list('corporate.intro.points')" :key="i" class="flex items-start gap-3 text-slate-700">
                            <Icon name="check-badge" class="mt-0.5 h-6 w-6 shrink-0 text-accent-500" />
                            {{ p.text }}
                        </li>
                    </ul>
                    <component :is="linkTag(c('corporate.intro.button_link'))" v-if="c('corporate.intro.button_label')" :href="c('corporate.intro.button_link')" class="btn-primary mt-9">
                        {{ c('corporate.intro.button_label') }}
                        <Icon name="chevron-right" class="h-4 w-4" />
                    </component>
                </div>
            </div>
        </section>

        <!-- Services -->
        <section v-if="services.length" class="relative overflow-hidden bg-gradient-to-br from-brand-50 via-white to-accent-100/60 py-20 sm:py-24">
            <div class="pointer-events-none absolute inset-0 opacity-60 [background-image:radial-gradient(rgb(47_123_240/0.2)_1.2px,transparent_1.2px)] [background-size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,transparent_30%,black)]" />
            <div class="pointer-events-none absolute -right-24 top-0 h-96 w-96 rounded-full bg-brand-300/30 blur-3xl" />
            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('corporate.services.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('corporate.services.title') }}</h2>
                    <p class="section-subtitle">{{ c('corporate.services.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="service in services"
                        :key="service.id"
                        :href="route('services.show', service.slug)"
                        class="card group relative overflow-hidden border-white bg-white/80 p-7 backdrop-blur-md transition duration-300 hover:-translate-y-1.5 hover:border-brand-300 hover:bg-white hover:shadow-2xl hover:shadow-brand-500/10"
                    >
                        <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-brand-500 to-accent-400 opacity-0 transition group-hover:opacity-100" />
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-50 to-accent-100 text-brand-600 transition duration-300 group-hover:rotate-3 group-hover:from-brand-600 group-hover:to-accent-500 group-hover:text-white">
                            <Icon :name="service.icon" class="h-7 w-7" />
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-brand-900">{{ service.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ service.short_description }}</p>
                        <span v-if="c('corporate.services.card_cta')" class="mt-4 inline-block text-sm font-semibold text-accent-600">
                            {{ c('corporate.services.card_cta') }} <span class="inline-block transition group-hover:translate-x-1">→</span>
                        </span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Numbers band -->
        <section class="relative overflow-hidden bg-brand-900 py-16 text-white sm:py-20">
            <div v-if="c('corporate.stats.image')" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('corporate.stats.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-b from-brand-900/90 via-brand-900/80 to-brand-900/95" />
            <div class="container-x relative grid grid-cols-2 gap-8 lg:grid-cols-4">
                <div v-for="(s, i) in list('corporate.stats.items')" :key="i" class="text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/20 backdrop-blur">
                        <Icon :name="s.icon" class="h-6 w-6 text-accent-300" />
                    </span>
                    <p class="mt-4 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">{{ s.value }}</p>
                    <p class="mt-1 text-sm text-slate-300">{{ s.label }}</p>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="py-20 sm:py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('corporate.process.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('corporate.process.title') }}</h2>
                </div>
                <div class="relative mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="(step, i) in list('corporate.process.items')" :key="i" class="card group relative p-7 text-center transition duration-300 hover:-translate-y-1.5 hover:shadow-xl">
                        <span class="absolute -top-4 left-1/2 flex h-8 w-8 -translate-x-1/2 items-center justify-center rounded-full bg-brand-900 text-sm font-bold text-white shadow">{{ i + 1 }}</span>
                        <span class="mx-auto mt-2 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-50 to-accent-100 text-brand-600 transition duration-300 group-hover:from-brand-600 group-hover:to-accent-500 group-hover:text-white">
                            <Icon :name="step.icon" class="h-8 w-8" />
                        </span>
                        <h3 class="mt-5 text-lg font-bold text-brand-900">{{ step.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ step.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Packages -->
        <section v-if="packages.length" class="bg-slate-50 py-20 sm:py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('corporate.plans.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('corporate.plans.title') }}</h2>
                    <p class="section-subtitle">{{ c('corporate.plans.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <PackageCard v-for="pkg in packages" :key="pkg.id" :pkg="pkg" />
                </div>
            </div>
        </section>

        <!-- Clients -->
        <section v-if="clients.length" class="py-16">
            <div class="container-x">
                <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400">{{ c('corporate.clients.title') }}</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <div
                        v-for="cl in clients"
                        :key="cl.id"
                        class="flex h-20 w-44 items-center justify-center rounded-2xl border border-slate-100 bg-white px-6 grayscale transition duration-300 hover:border-brand-200 hover:shadow-lg hover:grayscale-0"
                    >
                        <img v-if="cl.logo" :src="logoSrc(cl.logo)" :alt="cl.name" class="max-h-12 w-auto max-w-full object-contain" />
                        <span v-else class="font-display text-lg font-bold text-slate-400">{{ cl.name }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section v-if="testimonials.length" class="relative overflow-hidden bg-brand-900 py-20 text-white sm:py-24">
            <div class="grid-bg absolute inset-0 opacity-30 [mask-image:radial-gradient(ellipse_at_center,black,transparent_75%)]" />
            <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-accent-500/25 blur-3xl" />
            <div class="container-x relative">
                <h2 class="text-center text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('corporate.testimonials.title') }}</h2>
                <div class="mt-14 grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div v-for="t in testimonials" :key="t.id" class="relative rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur">
                        <span class="pointer-events-none absolute right-6 top-3 select-none font-display text-7xl font-black leading-none text-white/10">“</span>
                        <div class="relative flex gap-0.5 text-amber-400">
                            <Icon v-for="n in t.rating" :key="n" name="star" class="h-5 w-5 fill-current" />
                        </div>
                        <p class="relative mt-4 text-lg leading-relaxed text-slate-200">"{{ t.message }}"</p>
                        <div class="relative mt-6 flex items-center gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-accent-500 to-brand-500 text-sm font-bold">{{ t.name?.charAt(0) }}</span>
                            <div>
                                <p class="font-semibold">{{ t.name }}</p>
                                <p class="text-sm text-slate-400">{{ t.designation }}<span v-if="t.company"> · {{ t.company }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bottom banner -->
        <section class="relative overflow-hidden bg-brand-900 py-20 text-white sm:py-24">
            <div v-if="c('corporate.cta.image')" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('corporate.cta.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900/95 via-brand-900/80 to-brand-900/50" />
            <div class="container-x relative max-w-3xl text-center">
                <span class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur">
                    <Icon name="building-office" class="h-7 w-7" />
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('corporate.cta.title') }}</h2>
                <p class="mt-4 text-lg text-slate-200">{{ c('corporate.cta.text') }}</p>
                <div class="mt-9 flex flex-wrap justify-center gap-3">
                    <component :is="linkTag(c('corporate.cta.primary_link'))" v-if="c('corporate.cta.primary_label')" :href="c('corporate.cta.primary_link')" class="btn-primary">
                        {{ c('corporate.cta.primary_label') }}
                    </component>
                    <component :is="linkTag(c('corporate.cta.secondary_link'))" v-if="c('corporate.cta.secondary_label')" :href="c('corporate.cta.secondary_link')" class="btn-outline">
                        {{ c('corporate.cta.secondary_label') }}
                    </component>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
