<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import { useContent } from '@/composables/useContent';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    posts: Object,
});

const { c } = useContent();

const cover = (post) => (post.image ? `/storage/${post.image}` : `/images/blog-${(post.id % 3) + 1}.svg`);
const formatDate = (d) => (d ? new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '');
const readMinutes = (post) => Math.max(1, Math.round(String(post.content ?? '').replace(/<[^>]*>/g, ' ').split(/\s+/).filter(Boolean).length / 200));

// The first post of the first page is shown big; the rest go in the grid.
const featured = computed(() => (props.posts.current_page === 1 ? props.posts.data[0] : null));
const rest = computed(() => (featured.value ? props.posts.data.slice(1) : props.posts.data));
</script>

<template>
    <Head title="Blog" />

    <PublicLayout>
        <PageHero page-key="blog" />

        <section class="relative overflow-hidden bg-gradient-to-b from-sky-50 via-white to-white py-16 sm:py-20">
            <div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-teal-200/40 blur-3xl" />
            <div class="pointer-events-none absolute -right-24 top-96 h-72 w-72 rounded-full bg-amber-200/40 blur-3xl" />

            <div class="container-x relative">
                <!-- Featured -->
                <Link v-if="featured" :href="route('blog.show', featured.slug)" class="card group grid grid-cols-1 overflow-hidden border-white shadow-xl transition hover:shadow-2xl lg:grid-cols-2">
                    <div class="relative h-60 overflow-hidden bg-brand-900 sm:h-72 lg:h-full lg:min-h-[320px]">
                        <img :src="cover(featured)" :alt="featured.title" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                        <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-amber-400 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-950">
                            <Icon name="sparkles" class="h-3.5 w-3.5" />
                            {{ c('blog.index.featured_label') }}
                        </span>
                    </div>
                    <div class="flex flex-col justify-center p-7 sm:p-10">
                        <p class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs font-medium text-slate-400">
                            <span class="inline-flex items-center gap-1.5"><Icon name="calendar" class="h-4 w-4" />{{ formatDate(featured.published_at) }}</span>
                            <span class="inline-flex items-center gap-1.5"><Icon name="clock" class="h-4 w-4" />{{ readMinutes(featured) }} {{ c('blog.show.read_time') }}</span>
                        </p>
                        <h2 class="mt-3 text-2xl font-extrabold leading-tight tracking-tight text-brand-900 transition group-hover:text-teal-700 sm:text-3xl">{{ featured.title }}</h2>
                        <p class="mt-3 line-clamp-3 text-slate-500">{{ featured.excerpt }}</p>
                        <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-teal-600">
                            {{ c('blog.index.read_more') }}
                            <Icon name="chevron-right" class="h-4 w-4 transition group-hover:translate-x-1" />
                        </span>
                    </div>
                </Link>

                <!-- Grid -->
                <h3 v-if="rest.length" class="mt-14 flex items-center gap-3 text-xl font-extrabold text-brand-900">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-50 text-teal-600"><Icon name="newspaper" class="h-5 w-5" /></span>
                    {{ c('blog.index.latest_title') }}
                </h3>
                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3" :class="rest.length ? '' : 'hidden'">
                    <Link
                        v-for="post in rest"
                        :key="post.id"
                        :href="route('blog.show', post.slug)"
                        class="card group relative flex flex-col overflow-hidden border-white transition duration-300 hover:-translate-y-1.5 hover:border-teal-300 hover:shadow-2xl hover:shadow-teal-500/10"
                    >
                        <div class="relative h-48 overflow-hidden bg-brand-900">
                            <img :src="cover(post)" :alt="post.title" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                            <span class="absolute inset-0 bg-gradient-to-t from-teal-900/40 to-transparent opacity-0 transition group-hover:opacity-100" />
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <p class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-medium text-slate-400">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-teal-50 px-2.5 py-1 text-teal-700"><Icon name="calendar" class="h-3.5 w-3.5" />{{ formatDate(post.published_at) }}</span>
                                <span class="inline-flex items-center gap-1"><Icon name="clock" class="h-3.5 w-3.5" />{{ readMinutes(post) }} {{ c('blog.show.read_time') }}</span>
                            </p>
                            <h3 class="mt-3 line-clamp-2 text-lg font-bold text-brand-900 transition group-hover:text-teal-700">{{ post.title }}</h3>
                            <p class="mt-2 line-clamp-2 flex-1 text-sm text-slate-500">{{ post.excerpt }}</p>
                            <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-teal-600">
                                {{ c('blog.index.read_more') }}
                                <Icon name="chevron-right" class="h-4 w-4 transition group-hover:translate-x-1" />
                            </span>
                        </div>
                    </Link>
                </div>

                <p v-if="!posts.data.length" class="mt-12 text-center text-slate-500">{{ c('blog.index.empty') }}</p>

                <div v-if="posts.links.length > 3" class="mt-14 flex flex-wrap justify-center gap-2">
                    <Link
                        v-for="(link, i) in posts.links"
                        :key="i"
                        :href="link.url || '#'"
                        v-html="link.label"
                        class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-full px-4 py-2 text-sm font-medium"
                        :class="link.active ? 'bg-brand-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                    />
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="relative overflow-hidden py-20 text-white">
            <div class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${c('blog.cta.image')}')` }" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900/95 via-brand-900/85 to-brand-900/60" />
            <div class="container-x relative flex flex-col items-start gap-6 md:flex-row md:items-center md:justify-between">
                <div class="flex items-start gap-5">
                    <span class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur sm:flex"><Icon :name="c('blog.cta.icon')" class="h-7 w-7" /></span>
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight sm:text-3xl">{{ c('blog.cta.title') }}</h2>
                        <p class="mt-2 max-w-xl text-slate-200">{{ c('blog.cta.text') }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <Link :href="route('packages.index')" class="btn-primary">{{ c('blog.cta.button') }}</Link>
                    <Link :href="route('contact.index')" class="btn-outline">{{ c('blog.cta.button2') }}</Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
