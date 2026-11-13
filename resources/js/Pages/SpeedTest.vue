<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const { c, list } = useContent();

// only http(s) addresses may be embedded
const embedUrl = computed(() => {
    const url = c('speedtest.embed_url');
    return /^https?:\/\//i.test(url) ? url : '';
});
const height = computed(() => Math.min(1200, Math.max(300, Number(c('speedtest.embed_height')) || 560)));
</script>

<template>
    <Head :title="c('speedtest.hero.title', 'Speed test')" />

    <PublicLayout>
        <PageHero page-key="speedtest" />

        <section class="bg-white py-20 sm:py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="font-display text-4xl font-normal leading-tight text-slate-900 sm:text-5xl">{{ c('speedtest.heading') }}</h2>
                    <p class="section-subtitle">{{ c('speedtest.subtitle') }}</p>
                </div>

                <div v-if="embedUrl" class="mx-auto mt-12 max-w-5xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
                    <iframe :src="embedUrl" :title="c('speedtest.heading')" :height="height" class="block w-full border-0" loading="lazy" />
                </div>
                <p v-if="embedUrl" class="mt-6 text-center text-sm">
                    <a :href="embedUrl" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 font-medium text-accent-600 hover:underline">
                        <Icon name="bolt" class="h-4 w-4" />
                        {{ c('speedtest.open_label') }}
                    </a>
                </p>
                <p class="mx-auto mt-4 max-w-2xl text-center text-xs leading-6 text-slate-500">{{ c('speedtest.note') }}</p>

                <div class="mx-auto mt-14 grid max-w-5xl gap-6 md:grid-cols-3">
                    <div v-for="(tip, i) in list('speedtest.tips')" :key="i" class="rounded-xl border border-slate-200 bg-white p-7 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10">
                        <Icon :name="tip.icon || 'sparkles'" class="h-10 w-10 stroke-[1.25] text-accent-500" />
                        <h3 class="mt-4 font-display text-lg text-slate-900">{{ tip.title }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-500">{{ tip.text }}</p>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
