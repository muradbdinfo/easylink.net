<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    post: Object,
    recent: Array,
});

const cover = (post) => (post.image ? `/storage/${post.image}` : `/images/blog-${(post.id % 3) + 1}.svg`);
const formatDate = (d) => new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
</script>

<template>
    <Head :title="post.title" />

    <PublicLayout>
        <section class="page-hero">
            <div class="grid-bg absolute inset-0 opacity-60 [mask-image:radial-gradient(ellipse_at_top_left,black,transparent_70%)]" />
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-accent-500/30 blur-3xl" />
            <div class="container-x relative max-w-3xl">
                <Link :href="route('blog.index')" class="text-sm text-slate-400 hover:text-white">← Back to blog</Link>
                <p class="mt-6 text-sm text-brand-300">{{ formatDate(post.published_at) }} · {{ post.author_name }}</p>
                <h1 class="mt-3 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">{{ post.title }}</h1>
            </div>
        </section>

        <section class="py-20">
            <div class="container-x grid grid-cols-1 gap-12 lg:grid-cols-3">
                <div class="lg:col-span-2">
                <img :src="cover(post)" :alt="post.title" class="mb-10 aspect-[16/9] w-full rounded-3xl object-cover shadow-lg" />
                <article class="whitespace-pre-line text-lg leading-relaxed text-slate-600 ">{{ post.content }}</article>
                </div>

                <aside v-if="recent.length" class="space-y-4">
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-400">Recent posts</h3>
                    <Link v-for="r in recent" :key="r.id" :href="route('blog.show', r.slug)" class="card block p-5 transition hover:border-brand-300 hover:shadow-md">
                        <p class="text-sm font-semibold text-brand-900">{{ r.title }}</p>
                    </Link>
                </aside>
            </div>
        </section>
    </PublicLayout>
</template>
