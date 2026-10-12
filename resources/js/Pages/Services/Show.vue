<script setup>
import Icon from '@/Components/Icon.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    service: Object,
    related: Array,
});
</script>

<template>
    <Head :title="service.title" />

    <PublicLayout>
        <section class="page-hero">
            <div class="grid-bg absolute inset-0 opacity-60 [mask-image:radial-gradient(ellipse_at_top_left,black,transparent_70%)]" />
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-accent-500/30 blur-3xl" />
            <div class="container-x relative">
                <Link :href="route('services.index')" class="text-sm text-slate-400 hover:text-white">← All services</Link>
                <span class="mt-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10">
                    <Icon :name="service.icon" class="h-8 w-8 text-brand-300" />
                </span>
                <h1 class="mt-5 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ service.title }}</h1>
                <p class="mt-4 max-w-2xl text-lg text-slate-300">{{ service.short_description }}</p>
            </div>
        </section>

        <section class="py-20">
            <div class="container-x grid grid-cols-1 gap-12 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="whitespace-pre-line text-lg leading-relaxed text-slate-600">{{ service.description }}</div>
                    <Link :href="route('contact.index')" class="btn-primary mt-10">Ask about this service</Link>
                </div>

                <aside v-if="related.length" class="space-y-4">
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-400">Related services</h3>
                    <Link
                        v-for="r in related"
                        :key="r.id"
                        :href="route('services.show', r.slug)"
                        class="card flex items-center gap-4 p-5 transition hover:border-brand-300 hover:shadow-md"
                    >
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                            <Icon :name="r.icon" class="h-6 w-6" />
                        </span>
                        <span class="text-sm font-semibold text-brand-900">{{ r.title }}</span>
                    </Link>
                </aside>
            </div>
        </section>
    </PublicLayout>
</template>
