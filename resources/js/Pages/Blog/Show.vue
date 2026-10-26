<script setup>
import Icon from '@/Components/Icon.vue';
import { useContent } from '@/composables/useContent';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    post: Object,
    recent: Array,
});

const { c, richHtml } = useContent();

const cover = (post) => (post.image ? `/storage/${post.image}` : `/images/blog-${(post.id % 3) + 1}.svg`);
const formatDate = (d) => (d ? new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' }) : '');
const readMinutes = computed(() => Math.max(1, Math.round(String(props.post.content ?? '').replace(/<[^>]*>/g, ' ').split(/\s+/).filter(Boolean).length / 200)));

const url = () => (typeof window !== 'undefined' ? window.location.href : '');
const share = (target) => {
    const u = encodeURIComponent(url());
    const t = encodeURIComponent(props.post.title);
    const links = {
        facebook: `https://www.facebook.com/sharer/sharer.php?u=${u}`,
        whatsapp: `https://wa.me/?text=${t}%20${u}`,
        x: `https://twitter.com/intent/tweet?text=${t}&url=${u}`,
    };
    window.open(links[target], '_blank', 'noopener');
};

const copied = ref(false);
const copyLink = async () => {
    try {
        await navigator.clipboard.writeText(url());
        copied.value = true;
        setTimeout(() => (copied.value = false), 2000);
    } catch {
        window.prompt('Copy this link', url());
    }
};
</script>

<template>
    <Head :title="post.title" />

    <PublicLayout>
        <section class="page-hero !py-16 sm:!py-24">
            <div class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${cover(post)}')` }" />
            <div class="absolute inset-0 bg-gradient-to-b from-brand-900/85 via-brand-900/80 to-brand-900/95" />
            <div class="grid-bg absolute inset-0 opacity-30 [mask-image:radial-gradient(ellipse_at_top_left,black,transparent_70%)]" />
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-accent-500/30 blur-3xl" />
            <div class="container-x relative max-w-3xl">
                <Link :href="route('blog.index')" class="inline-flex min-h-[44px] items-center gap-1.5 text-sm text-slate-300 hover:text-white">
                    <Icon name="chevron-right" class="h-4 w-4 rotate-180" />
                    {{ c('blog.show.back') }}
                </Link>
                <p class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-brand-200">
                    <span class="inline-flex items-center gap-1.5"><Icon name="calendar" class="h-4 w-4" />{{ formatDate(post.published_at) }}</span>
                    <span v-if="post.author_name" class="inline-flex items-center gap-1.5"><Icon name="users" class="h-4 w-4" />{{ post.author_name }}</span>
                    <span class="inline-flex items-center gap-1.5"><Icon name="clock" class="h-4 w-4" />{{ readMinutes }} {{ c('blog.show.read_time') }}</span>
                </p>
                <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight sm:text-5xl">{{ post.title }}</h1>
            </div>
        </section>

        <section class="bg-gradient-to-b from-sky-50/60 to-white py-14 sm:py-20">
            <div class="container-x grid grid-cols-1 gap-12 lg:grid-cols-3">
                <div class="min-w-0 lg:col-span-2">
                    <img :src="cover(post)" :alt="post.title" class="relative z-10 -mt-24 mb-10 aspect-[16/9] w-full rounded-3xl border-4 border-white object-cover shadow-2xl sm:-mt-32" />

                    <article class="rich text-lg leading-relaxed text-slate-600" v-html="richHtml(post.content)" />

                    <div class="mt-12 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-6">
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-brand-900"><Icon name="rss" class="h-5 w-5 text-teal-600" />{{ c('blog.show.share') }}</span>
                        <button type="button" class="min-h-[44px] rounded-full bg-[#1877f2] px-4 text-sm font-semibold text-white transition hover:opacity-90" @click="share('facebook')">Facebook</button>
                        <button type="button" class="min-h-[44px] rounded-full bg-[#25d366] px-4 text-sm font-semibold text-white transition hover:opacity-90" @click="share('whatsapp')">WhatsApp</button>
                        <button type="button" class="min-h-[44px] rounded-full bg-slate-900 px-4 text-sm font-semibold text-white transition hover:opacity-90" @click="share('x')">X</button>
                        <button type="button" class="min-h-[44px] rounded-full bg-slate-100 px-4 text-sm font-semibold text-slate-700 transition hover:bg-slate-200" @click="copyLink">{{ copied ? '✓' : 'Link' }}</button>
                    </div>
                </div>

                <aside class="space-y-4 lg:pt-2">
                    <template v-if="recent.length">
                        <h3 class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-slate-400"><Icon name="newspaper" class="h-4 w-4" />{{ c('blog.show.recent') }}</h3>
                        <Link v-for="r in recent" :key="r.id" :href="route('blog.show', r.slug)" class="card group flex items-center gap-4 overflow-hidden p-3 transition hover:border-teal-300 hover:shadow-lg">
                            <img :src="cover(r)" :alt="r.title" loading="lazy" class="h-16 w-20 shrink-0 rounded-xl object-cover" />
                            <span class="min-w-0">
                                <span class="line-clamp-2 text-sm font-semibold text-brand-900 transition group-hover:text-teal-700">{{ r.title }}</span>
                                <span class="mt-1 block text-xs text-slate-400">{{ formatDate(r.published_at) }}</span>
                            </span>
                        </Link>
                    </template>

                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-900 via-brand-800 to-accent-600 p-6 text-white">
                        <Icon :name="c('blog.cta.icon')" class="pointer-events-none absolute -bottom-6 -right-4 h-32 w-32 -rotate-12 text-white/10" />
                        <h4 class="relative text-lg font-extrabold">{{ c('blog.cta.title') }}</h4>
                        <p class="relative mt-2 text-sm text-slate-200">{{ c('blog.cta.text') }}</p>
                        <Link :href="route('packages.index')" class="btn-primary relative mt-5 !bg-white !text-brand-900 !shadow-none">{{ c('blog.cta.button') }}</Link>
                    </div>
                </aside>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.rich :deep(p) {
    margin-bottom: 1.2em;
}
.rich :deep(h2),
.rich :deep(h3),
.rich :deep(h4) {
    margin: 1.6em 0 0.6em;
    font-weight: 800;
    line-height: 1.25;
    color: #0b1b3f;
}
.rich :deep(h2) {
    font-size: 1.6em;
}
.rich :deep(h3) {
    font-size: 1.3em;
}
.rich :deep(a) {
    color: #0773b8;
    text-decoration: underline;
}
.rich :deep(strong) {
    color: #0b1b3f;
}
.rich :deep(ul),
.rich :deep(ol) {
    margin: 0 0 1.2em 1.4em;
    list-style: revert;
}
.rich :deep(li) {
    margin-bottom: 0.4em;
}
.rich :deep(blockquote) {
    margin: 1.5em 0;
    border-left: 4px solid #2f7bf0;
    background: #eff6ff;
    padding: 0.8em 1.2em;
    border-radius: 0 0.75rem 0.75rem 0;
    font-style: italic;
}
.rich :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 1rem;
    margin: 1.5em 0;
}
.rich :deep(table) {
    display: block;
    max-width: 100%;
    overflow-x: auto;
    margin: 1.5em 0;
    border-collapse: collapse;
}
.rich :deep(td),
.rich :deep(th) {
    border: 1px solid #e2e8f0;
    padding: 0.5em 0.8em;
}
.rich :deep(iframe) {
    max-width: 100%;
}
.rich :deep(pre) {
    overflow-x: auto;
    background: #0b1b3f;
    color: #e2e8f0;
    padding: 1em;
    border-radius: 0.75rem;
}
</style>
