<script setup>
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    posts: Object,
});

const formatDate = (d) => new Date(d).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
</script>

<template>
    <Head title="Blog" />

    <PublicLayout>
        <PageHero eyebrow="Blog" title="Blog &amp; news" subtitle="Internet, technology and the latest from EasyLink." />

        <section class="py-20">
            <div class="container-x">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <Link v-for="post in posts.data" :key="post.id" :href="route('blog.show', post.slug)" class="card group overflow-hidden transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-brand-700 via-brand-900 to-accent-600">
                            <div class="grid-bg absolute inset-0 opacity-50" />
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-medium text-slate-400">{{ formatDate(post.published_at) }}</p>
                            <h3 class="mt-1 line-clamp-2 text-lg font-bold text-brand-900 group-hover:text-brand-600">{{ post.title }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-500">{{ post.excerpt }}</p>
                        </div>
                    </Link>
                </div>

                <p v-if="!posts.data.length" class="mt-12 text-center text-slate-500">No posts yet.</p>

                <div v-if="posts.links.length > 3" class="mt-14 flex flex-wrap justify-center gap-2">
                    <Link
                        v-for="(link, i) in posts.links"
                        :key="i"
                        :href="link.url || '#'"
                        v-html="link.label"
                        class="rounded-full px-4 py-2 text-sm font-medium"
                        :class="link.active ? 'bg-brand-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                    />
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
