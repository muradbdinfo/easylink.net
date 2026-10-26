<script setup>
import Icon from '@/Components/Icon.vue';
import PackageCard from '@/Components/Public/PackageCard.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    packages: Array,
    type: String,
});

const { c, list } = useContent();

// Internal paths go through Inertia, full URLs open as normal links.
const linkTag = (href) => (href?.startsWith('/') ? Link : 'a');
</script>

<template>
    <Head :title="c('packages.hero.title', 'Internet packages')" />

    <PublicLayout>
        <PageHero page-key="packages" />

        <!-- Trust strip -->
        <section class="relative z-10 -mt-10">
            <div class="container-x">
                <div class="grid grid-cols-2 gap-4 rounded-3xl border border-slate-200/70 bg-white p-5 shadow-xl shadow-slate-900/5 sm:p-7 lg:grid-cols-4">
                    <div v-for="(item, i) in list('packages.trust.items')" :key="i" class="flex items-center gap-3">
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

        <!-- Plans -->
        <section class="relative overflow-hidden bg-white py-20 sm:py-24">
            <div v-if="c('packages.plans.image')" class="absolute inset-0 bg-cover bg-right opacity-30" :style="{ backgroundImage: `url('${c('packages.plans.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-white/60" />
            <div class="absolute inset-0 bg-gradient-to-b from-white via-transparent to-white" />
            <div class="pointer-events-none absolute -left-24 top-20 h-80 w-80 rounded-full bg-accent-300/25 blur-3xl" />

            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('packages.plans.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('packages.plans.title') }}</h2>
                    <p class="section-subtitle">{{ c('packages.plans.subtitle') }}</p>
                </div>

                <div class="mx-auto mt-10 flex w-fit rounded-full border border-slate-200 bg-white/90 p-1.5 shadow-sm backdrop-blur">
                    <Link
                        :href="route('packages.index', { type: 'home' })"
                        class="inline-flex min-h-[44px] items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition sm:px-7"
                        :class="type === 'home' ? 'bg-brand-900 text-white shadow' : 'text-slate-500 hover:text-brand-900'"
                    >
                        <Icon name="home" class="h-4 w-4" />
                        {{ c('packages.tab_home', 'Home') }}
                    </Link>
                    <Link
                        :href="route('packages.index', { type: 'corporate' })"
                        class="inline-flex min-h-[44px] items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition sm:px-7"
                        :class="type === 'corporate' ? 'bg-brand-900 text-white shadow' : 'text-slate-500 hover:text-brand-900'"
                    >
                        <Icon name="building-office" class="h-4 w-4" />
                        {{ c('packages.tab_corporate', 'Corporate') }}
                    </Link>
                </div>

                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <PackageCard v-for="pkg in packages" :key="pkg.id" :pkg="pkg" />
                </div>

                <p v-if="!packages.length" class="mt-12 text-center text-slate-500">{{ c('packages.plans.empty') }}</p>
                <p v-else-if="c('packages.plans.footnote')" class="mt-10 text-center text-sm text-slate-500">{{ c('packages.plans.footnote') }}</p>
            </div>
        </section>

        <!-- Why choose us -->
        <section class="relative overflow-hidden bg-brand-900 py-20 text-white sm:py-24">
            <div v-if="c('packages.why.image')" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('packages.why.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-b from-brand-900/90 via-brand-900/80 to-brand-900/95" />
            <div class="grid-bg absolute inset-0 opacity-30 [mask-image:radial-gradient(ellipse_at_center,black,transparent_75%)]" />

            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow-dark">{{ c('packages.why.eyebrow') }}</span>
                    <h2 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('packages.why.title') }}</h2>
                    <p class="mt-3 text-lg text-slate-300">{{ c('packages.why.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(item, i) in list('packages.why.items')"
                        :key="i"
                        class="group rounded-3xl border border-white/10 bg-white/5 p-7 backdrop-blur transition duration-300 hover:-translate-y-1.5 hover:bg-white/10"
                    >
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-accent-500 to-brand-500 text-white shadow-lg transition duration-300 group-hover:rotate-3 group-hover:scale-110">
                            <Icon :name="item.icon" class="h-7 w-7" />
                        </span>
                        <h3 class="mt-5 text-lg font-bold">{{ item.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-300">{{ item.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section v-if="list('packages.faq.items').length" class="bg-slate-50 py-20 sm:py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('packages.faq.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('packages.faq.title') }}</h2>
                </div>
                <div class="mx-auto mt-12 max-w-3xl space-y-3">
                    <details v-for="(faq, i) in list('packages.faq.items')" :key="i" class="card group overflow-hidden">
                        <summary class="flex min-h-[56px] cursor-pointer list-none items-center justify-between gap-4 px-6 py-4 font-semibold text-brand-900 [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-3">
                                <Icon name="question-mark-circle" class="h-6 w-6 shrink-0 text-accent-500" />
                                {{ faq.question }}
                            </span>
                            <Icon name="chevron-right" class="h-5 w-5 shrink-0 text-slate-400 transition group-open:rotate-90" />
                        </summary>
                        <p class="border-t border-slate-100 px-6 py-5 pl-[3.75rem] text-sm leading-relaxed text-slate-600">{{ faq.answer }}</p>
                    </details>
                </div>
            </div>
        </section>

        <!-- Bottom banner -->
        <section class="relative overflow-hidden bg-brand-900 py-20 text-white sm:py-24">
            <div v-if="c('packages.cta.image')" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('packages.cta.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900/90 via-brand-900/70 to-brand-900/40" />
            <div class="container-x relative max-w-3xl text-center">
                <span class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur">
                    <Icon name="rocket-launch" class="h-7 w-7" />
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('packages.cta.title') }}</h2>
                <p class="mt-4 text-lg text-slate-200">{{ c('packages.cta.text') }}</p>
                <div class="mt-9 flex flex-wrap justify-center gap-3">
                    <component :is="linkTag(c('packages.cta.primary_link'))" v-if="c('packages.cta.primary_label')" :href="c('packages.cta.primary_link')" class="btn-primary">
                        {{ c('packages.cta.primary_label') }}
                    </component>
                    <component :is="linkTag(c('packages.cta.secondary_link'))" v-if="c('packages.cta.secondary_label')" :href="c('packages.cta.secondary_link')" class="btn-outline">
                        {{ c('packages.cta.secondary_label') }}
                    </component>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
