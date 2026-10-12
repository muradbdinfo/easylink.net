<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
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

const openFaq = ref(null);
const toggleFaq = (id) => (openFaq.value = openFaq.value === id ? null : id);
</script>

<template>
    <Head title="About us" />

    <PublicLayout>
        <PageHero eyebrow="About us" title="Built to keep Bangladesh connected" :subtitle="settings.tagline" />

        <section class="py-24">
            <div class="container-x grid grid-cols-1 items-center gap-14 lg:grid-cols-2">
                <div>
                    <span class="eyebrow">Our story</span>
                    <h2 class="section-title mt-4">Who we are</h2>
                    <p class="mt-5 whitespace-pre-line text-lg leading-relaxed text-slate-600">{{ settings.about_text }}</p>
                </div>
                <div>
                    <img src="/images/about.svg" alt="EasyLink network across Bangladesh" loading="lazy" class="mb-5 aspect-[16/10] w-full rounded-3xl object-cover shadow-xl" />
                    <div class="grid grid-cols-2 gap-5">
                    <div v-for="stat in stats" :key="stat.id" class="card flex flex-col items-center p-7 text-center">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                            <Icon :name="stat.icon" class="h-6 w-6" />
                        </span>
                        <span class="mt-3 font-display text-3xl font-extrabold text-brand-900">{{ stat.value }}{{ stat.suffix }}</span>
                        <span class="text-sm text-slate-500">{{ stat.label }}</span>
                    </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="partners.length" class="border-y border-slate-100 bg-slate-50 py-14">
            <div class="container-x">
                <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400">Technology partners &amp; clients</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-x-12 gap-y-5">
                    <span v-for="p in partners" :key="p.id" class="font-display text-lg font-bold text-slate-400">{{ p.name }}</span>
                </div>
            </div>
        </section>

        <section v-if="faqs.length" class="py-24">
            <div class="container-x max-w-3xl">
                <div class="text-center">
                    <span class="eyebrow">FAQ</span>
                    <h2 class="section-title mt-4">Frequently asked questions</h2>
                </div>
                <div class="mt-12 space-y-3">
                    <div v-for="faq in faqs" :key="faq.id" class="card overflow-hidden" :class="openFaq === faq.id ? 'border-brand-300' : ''">
                        <button class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left font-semibold text-brand-900" @click="toggleFaq(faq.id)">
                            {{ faq.question }}
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-brand-50 text-lg text-brand-600">{{ openFaq === faq.id ? '−' : '+' }}</span>
                        </button>
                        <div v-if="openFaq === faq.id" class="border-t border-slate-100 px-6 py-5 text-slate-600">
                            {{ faq.answer }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-brand-900 py-20 text-center text-white">
            <div class="container-x">
                <h2 class="text-3xl font-extrabold tracking-tight">Want to know more?</h2>
                <p class="mt-3 text-slate-300">Our team is happy to answer any question.</p>
                <Link :href="route('contact.index')" class="btn-primary mt-8">Contact us</Link>
            </div>
        </section>
    </PublicLayout>
</template>
