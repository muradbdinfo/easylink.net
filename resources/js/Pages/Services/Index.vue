<script setup>
import Icon from '@/Components/Icon.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    services: Array,
});
</script>

<template>
    <Head title="Services" />

    <PublicLayout>
        <PageHero eyebrow="Services" title="Our services" subtitle="From home to enterprise — every kind of connectivity solution." />

        <section class="py-20">
            <div class="container-x grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="service in services"
                    :key="service.id"
                    :href="route('services.show', service.slug)"
                    class="card group p-7 transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-xl"
                >
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 transition group-hover:bg-brand-600 group-hover:text-white">
                        <Icon :name="service.icon" class="h-7 w-7" />
                    </span>
                    <h3 class="mt-5 text-lg font-bold text-brand-900">{{ service.title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ service.short_description }}</p>
                    <span class="mt-4 inline-block text-sm font-semibold text-accent-600">Learn more →</span>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
