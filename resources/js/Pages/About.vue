<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import { useContent } from '@/composables/useContent';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

defineProps({
    stats: Array,
    partners: Array,
    faqs: Array,
});

const page = usePage();
const settings = computed(() => page.props.settings ?? {});
const { c, list, richHtml } = useContent();

const logoSrc = (logo) => (logo.startsWith('/') || logo.startsWith('http') ? logo : `/storage/${logo}`);

const openFaq = ref(null);
const toggleFaq = (id) => (openFaq.value = openFaq.value === id ? null : id);
</script>

<template>
    <Head title="About us" />

    <PublicLayout>
        <PageHero page-key="about" />

        <!-- Story -->
        <section class="py-20 sm:py-24">
            <div class="container-x grid grid-cols-1 items-center gap-14 lg:grid-cols-2">
                <div>
                    <span class="eyebrow">{{ c('about.story.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('about.story.title') }}</h2>
                    <div class="rich mt-5 text-lg leading-relaxed text-slate-600" v-html="richHtml(settings.about_text)" />
                </div>
                <div class="relative">
                    <div class="pointer-events-none absolute -inset-4 rounded-[2rem] bg-gradient-to-br from-brand-100 via-white to-accent-100 opacity-80" />
                    <img :src="c('about.story.image')" :alt="c('about.story.title')" loading="lazy" class="relative aspect-[4/3] w-full rounded-3xl object-cover shadow-2xl" />
                    <div class="absolute -bottom-6 left-4 flex items-center gap-3 rounded-2xl bg-white px-4 py-3 shadow-xl sm:-left-6">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-accent-500 text-white">
                            <Icon :name="c('about.story.badge_icon')" class="h-6 w-6" />
                        </span>
                        <span class="text-sm font-bold leading-tight text-brand-900">
                            {{ c('about.story.badge_title') }}
                            <span class="block text-xs font-normal text-slate-500">{{ c('about.story.badge_text') }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission / vision / values -->
        <section v-if="list('about.pillars.items').length" class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white py-20 sm:py-24">
            <div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-brand-200/40 blur-3xl" />
            <div class="pointer-events-none absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-accent-200/40 blur-3xl" />
            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('about.pillars.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('about.pillars.title') }}</h2>
                    <p class="section-subtitle">{{ c('about.pillars.subtitle') }}</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div v-for="(p, i) in list('about.pillars.items')" :key="i" class="card group relative overflow-hidden p-8 transition duration-300 hover:-translate-y-1.5 hover:shadow-2xl">
                        <Icon :name="p.icon" class="pointer-events-none absolute -bottom-8 -right-6 h-28 w-28 -rotate-12 text-brand-50 transition group-hover:scale-110" />
                        <span class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-accent-500 text-white shadow-lg">
                            <Icon :name="p.icon" class="h-7 w-7" />
                        </span>
                        <h3 class="relative mt-6 text-xl font-bold text-brand-900">{{ p.title }}</h3>
                        <p class="relative mt-3 leading-relaxed text-slate-500">{{ p.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Numbers -->
        <section v-if="stats.length" class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-[#1e1b6b] to-violet-900 py-20 text-white">
            <div class="grid-bg absolute inset-0 opacity-40 [mask-image:radial-gradient(ellipse_at_center,black,transparent_75%)]" />
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-accent-500/30 blur-3xl" />
            <div class="container-x relative">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow-dark">{{ c('about.stats.eyebrow') }}</span>
                    <h2 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('about.stats.title') }}</h2>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-5 lg:grid-cols-4">
                    <div v-for="stat in stats" :key="stat.id" class="flex flex-col items-center rounded-3xl border border-white/10 bg-white/5 p-6 text-center backdrop-blur">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-brand-300">
                            <Icon :name="stat.icon" class="h-6 w-6" />
                        </span>
                        <span class="mt-3 font-display text-3xl font-extrabold sm:text-4xl">{{ stat.value }}{{ stat.suffix }}</span>
                        <span class="mt-1 text-sm text-slate-300">{{ stat.label }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why us -->
        <section v-if="list('about.why.items').length" class="py-20 sm:py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">{{ c('about.why.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('about.why.title') }}</h2>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="(w, i) in list('about.why.items')" :key="i" class="flex items-start gap-4 rounded-3xl border border-slate-200/70 bg-white p-6 shadow-sm transition hover:border-brand-300 hover:shadow-lg">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-400 to-violet-600 text-white shadow-md shadow-violet-500/25">
                            <Icon :name="w.icon" class="h-6 w-6" />
                        </span>
                        <div>
                            <p class="font-bold text-brand-900">{{ w.title }}</p>
                            <p class="mt-1 text-sm leading-relaxed text-slate-500">{{ w.text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners -->
        <section v-if="partners.length" class="border-y border-slate-100 bg-slate-50 py-14">
            <div class="container-x">
                <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400">{{ c('about.partners.label') }}</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-x-8 gap-y-5">
                    <div v-for="p in partners" :key="p.id" class="flex h-16 items-center justify-center rounded-2xl border border-slate-100 bg-white px-5 grayscale transition hover:grayscale-0">
                        <img v-if="p.logo" :src="logoSrc(p.logo)" :alt="p.name" class="max-h-10 w-auto object-contain" />
                        <span v-else class="font-display text-lg font-bold text-slate-400">{{ p.name }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section v-if="faqs.length" class="py-20 sm:py-24">
            <div class="container-x max-w-3xl">
                <div class="text-center">
                    <span class="eyebrow">{{ c('about.faq.eyebrow') }}</span>
                    <h2 class="section-title mt-4">{{ c('about.faq.title') }}</h2>
                </div>
                <div class="mt-12 space-y-3">
                    <div v-for="faq in faqs" :key="faq.id" class="card overflow-hidden" :class="openFaq === faq.id ? 'border-brand-300' : ''">
                        <button class="flex min-h-[56px] w-full items-center justify-between gap-4 px-6 py-4 text-left font-semibold text-brand-900" :aria-expanded="openFaq === faq.id" @click="toggleFaq(faq.id)">
                            {{ faq.question }}
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-violet-100 text-lg text-violet-600">{{ openFaq === faq.id ? '−' : '+' }}</span>
                        </button>
                        <div v-if="openFaq === faq.id" class="rich border-t border-slate-100 px-6 py-5 text-slate-600" v-html="richHtml(faq.answer)" />
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="relative overflow-hidden py-24 text-center text-white">
            <div class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('about.cta.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-b from-brand-900/85 to-brand-900/95" />
            <div class="pointer-events-none absolute -left-20 bottom-0 h-72 w-72 rounded-full bg-accent-500/30 blur-3xl" />
            <div class="container-x relative">
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{ c('about.cta.title') }}</h2>
                <p class="mx-auto mt-3 max-w-xl text-slate-200">{{ c('about.cta.text') }}</p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <Link :href="route('contact.index')" class="btn-primary">{{ c('about.cta.button') }}</Link>
                    <Link :href="route('packages.index')" class="btn-outline">{{ c('about.cta.button2') }}</Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.rich :deep(p) {
    margin-bottom: 1em;
}
.rich :deep(p:last-child) {
    margin-bottom: 0;
}
.rich :deep(strong) {
    color: #0b1b3f;
}
.rich :deep(a) {
    color: #0773b8;
    text-decoration: underline;
}
.rich :deep(ul),
.rich :deep(ol) {
    margin: 0 0 1em 1.25em;
    list-style: revert;
}
</style>
