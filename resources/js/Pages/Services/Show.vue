<script setup>
import Icon from '@/Components/Icon.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useContent } from '@/composables/useContent';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    service: Object,
    related: Array,
});

const { c, list, richHtml } = useContent();
const settings = computed(() => usePage().props.settings ?? {});

const banner = computed(() => (props.service.image ? `/storage/${props.service.image}` : c('services.detail.default_image')));
const isExternal = (url) => /^(https?:)?\/\//.test(url) || url?.startsWith('mailto:') || url?.startsWith('tel:');
</script>

<template>
    <Head :title="service.title" />

    <PublicLayout>
        <!-- Banner -->
        <section class="page-hero !pb-28">
            <div v-if="banner" class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${banner}')` }" />
            <div class="absolute inset-0 bg-gradient-to-b from-brand-900/80 via-brand-900/70 to-brand-900/95" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900/80 via-transparent to-transparent" />
            <div class="grid-bg absolute inset-0 opacity-40 [mask-image:radial-gradient(ellipse_at_top_left,black,transparent_70%)]" />
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-accent-500/30 blur-3xl" />
            <Icon :name="service.icon" class="pointer-events-none absolute -bottom-10 right-6 hidden h-72 w-72 -rotate-12 text-white/10 md:block lg:right-24" />
            <div class="container-x relative">
                <Link :href="route('services.index')" class="inline-flex items-center gap-1.5 py-2 text-sm text-slate-300 hover:text-white">
                    <Icon name="chevron-right" class="h-4 w-4 rotate-180" />
                    {{ c('services.detail.back', 'All services') }}
                </Link>
                <span class="mt-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur">
                    <Icon :name="service.icon" class="h-8 w-8 text-white" />
                </span>
                <h1 class="mt-5 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ service.title }}</h1>
                <p class="mt-4 max-w-2xl text-lg text-slate-200">{{ service.short_description }}</p>
            </div>
        </section>

        <!-- Highlights overlapping the banner -->
        <section v-if="list('services.detail.facts').length" class="relative z-10 -mt-14">
            <div class="container-x">
                <div class="grid grid-cols-1 gap-4 rounded-3xl bg-white p-5 shadow-xl shadow-slate-900/10 ring-1 ring-slate-200/70 sm:grid-cols-3 sm:p-6">
                    <div v-for="(f, i) in list('services.detail.facts')" :key="i" class="flex items-start gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-accent-500 text-white shadow-md">
                            <Icon :name="f.icon" class="h-6 w-6" />
                        </span>
                        <div>
                            <p class="font-bold text-brand-900">{{ f.title }}</p>
                            <p class="mt-0.5 text-sm text-slate-500">{{ f.text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Body -->
        <section class="py-16 lg:py-20">
            <div class="container-x grid grid-cols-1 gap-10 lg:grid-cols-3 lg:gap-12">
                <div class="lg:col-span-2">
                    <h2 v-if="c('services.detail.about_title')" class="text-2xl font-extrabold tracking-tight text-brand-900">{{ c('services.detail.about_title') }}</h2>
                    <div class="rich-content mt-5" v-html="richHtml(service.description)" />
                    <component
                        :is="isExternal(c('services.detail.button_url')) ? 'a' : Link"
                        v-if="c('services.detail.button')"
                        :href="c('services.detail.button_url')"
                        class="btn-primary mt-10"
                    >
                        {{ c('services.detail.button') }}
                    </component>
                </div>

                <aside class="space-y-6">
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-900 to-brand-700 p-6 text-white shadow-xl">
                        <Icon name="headset" class="pointer-events-none absolute -bottom-6 -right-4 h-28 w-28 -rotate-12 text-white/10" />
                        <p class="relative text-lg font-bold">{{ c('services.detail.call_title') }}</p>
                        <p class="relative mt-1 text-sm text-slate-200">{{ c('services.detail.call_text') }}</p>
                        <a v-if="settings.hotline" :href="`tel:${settings.hotline}`" class="relative mt-4 inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-brand-900 transition hover:bg-brand-50">
                            <Icon name="phone" class="h-4 w-4" />
                            {{ settings.hotline }}
                        </a>
                    </div>

                    <div v-if="related.length" class="space-y-3">
                        <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-400">{{ c('services.detail.related_title') }}</h3>
                        <Link
                            v-for="r in related"
                            :key="r.id"
                            :href="route('services.show', r.slug)"
                            class="card group flex items-center gap-4 p-5 transition hover:-translate-y-0.5 hover:border-brand-300 hover:shadow-lg"
                        >
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-400 to-violet-600 text-white shadow-md shadow-violet-500/25 transition group-hover:bg-brand-600 group-hover:text-white">
                                <Icon :name="r.icon" class="h-6 w-6" />
                            </span>
                            <span class="min-w-0 flex-1 text-sm font-semibold text-brand-900">{{ r.title }}</span>
                            <Icon name="chevron-right" class="h-4 w-4 shrink-0 text-slate-400 transition group-hover:translate-x-1" />
                        </Link>
                    </div>
                </aside>
            </div>
        </section>
    </PublicLayout>
</template>

<style>
/* Readable typography for HTML written in the admin rich-text editor (no typography plugin installed). */
.rich-content {
    color: rgb(71 85 105);
    font-size: 1.0625rem;
    line-height: 1.8;
    overflow-wrap: anywhere;
}
.rich-content > :first-child { margin-top: 0; }
.rich-content p { margin: 1em 0; }
.rich-content h2, .rich-content h3, .rich-content h4 { color: rgb(11 27 63); font-weight: 800; line-height: 1.3; margin: 1.6em 0 0.6em; }
.rich-content h2 { font-size: 1.5rem; }
.rich-content h3 { font-size: 1.25rem; }
.rich-content h4 { font-size: 1.1rem; }
.rich-content ul, .rich-content ol { margin: 1em 0; padding-left: 1.4em; }
.rich-content ul { list-style: disc; }
.rich-content ol { list-style: decimal; }
.rich-content li { margin: 0.35em 0; }
.rich-content a { color: rgb(8 145 224); text-decoration: underline; }
.rich-content img { max-width: 100%; height: auto; border-radius: 1rem; margin: 1.2em 0; }
.rich-content blockquote { border-left: 4px solid rgb(147 197 253); background: rgb(239 246 255); padding: 0.8em 1.2em; border-radius: 0 0.75rem 0.75rem 0; margin: 1.2em 0; }
.rich-content table { width: 100%; border-collapse: collapse; display: block; overflow-x: auto; margin: 1.2em 0; }
.rich-content th, .rich-content td { border: 1px solid rgb(226 232 240); padding: 0.55em 0.8em; text-align: left; }
.rich-content th { background: rgb(248 250 252); color: rgb(11 27 63); }
.rich-content iframe { max-width: 100%; border-radius: 1rem; }
</style>
