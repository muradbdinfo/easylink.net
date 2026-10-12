<script setup>
import PackageCard from '@/Components/Public/PackageCard.vue';
import PageHero from '@/Components/Public/PageHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    packages: Array,
    type: String,
});
</script>

<template>
    <Head title="Internet packages" />

    <PublicLayout>
        <PageHero eyebrow="Pricing" title="Internet packages" subtitle="Pick the plan that fits your needs. Switch any time." />

        <section class="py-20">
            <div class="container-x">
                <div class="mx-auto flex w-fit rounded-full bg-slate-100 p-1.5">
                    <Link
                        :href="route('packages.index', { type: 'home' })"
                        class="rounded-full px-7 py-2.5 text-sm font-semibold transition"
                        :class="type === 'home' ? 'bg-white text-brand-900 shadow' : 'text-slate-500 hover:text-brand-900'"
                    >
                        Home
                    </Link>
                    <Link
                        :href="route('packages.index', { type: 'corporate' })"
                        class="rounded-full px-7 py-2.5 text-sm font-semibold transition"
                        :class="type === 'corporate' ? 'bg-white text-brand-900 shadow' : 'text-slate-500 hover:text-brand-900'"
                    >
                        Corporate
                    </Link>
                </div>

                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <PackageCard v-for="pkg in packages" :key="pkg.id" :pkg="pkg" />
                </div>

                <p v-if="!packages.length" class="mt-12 text-center text-slate-500">No packages available right now.</p>
            </div>
        </section>
    </PublicLayout>
</template>
