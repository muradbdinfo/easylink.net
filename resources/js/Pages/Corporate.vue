<script setup>
import Icon from '@/Components/Icon.vue';
import PackageCard from '@/Components/Public/PackageCard.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    services: Array,
    packages: Array,
    clients: Array,
    testimonials: Array,
});

const highlights = ['1:1 dedicated bandwidth', '99.9% uptime SLA', 'Redundant network', 'Dedicated account manager'];
</script>

<template>
    <Head title="Corporate solutions" />

    <PublicLayout>
        <section class="relative overflow-hidden bg-brand-900 py-24 text-white">
            <div class="grid-bg absolute inset-0 opacity-60 [mask-image:radial-gradient(ellipse_at_top_right,black,transparent_70%)]" />
            <div class="pointer-events-none absolute -right-20 -top-20 h-96 w-96 rounded-full bg-accent-500/30 blur-3xl" />
            <div class="container-x relative grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div>
                    <span class="eyebrow-dark">Enterprise connectivity</span>
                    <h1 class="mt-5 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">Reliable corporate internet for your business</h1>
                    <p class="mt-5 text-lg text-slate-300">Dedicated bandwidth, SLA guarantees, DDoS protection and 24/7 NOC monitoring — a complete connectivity solution.</p>
                    <Link :href="route('contact.index')" class="btn-primary mt-9">Get a free consultation</Link>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div v-for="item in highlights" :key="item" class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/5 p-5 text-sm font-semibold backdrop-blur">
                        <Icon name="check" class="h-5 w-5 shrink-0 text-brand-300" />
                        {{ item }}
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">Services</span>
                    <h2 class="section-title mt-4">Corporate services</h2>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
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
                    </Link>
                </div>
            </div>
        </section>

        <section class="bg-slate-50 py-24">
            <div class="container-x">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="eyebrow">Plans</span>
                    <h2 class="section-title mt-4">Dedicated corporate packages</h2>
                    <p class="section-subtitle">Choose the bandwidth that fits the size of your business.</p>
                </div>
                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <PackageCard v-for="pkg in packages" :key="pkg.id" :pkg="pkg" />
                </div>
            </div>
        </section>

        <section v-if="clients.length" class="py-16">
            <div class="container-x">
                <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-400">Organizations that trust us</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-x-12 gap-y-5">
                    <span v-for="c in clients" :key="c.id" class="font-display text-lg font-bold text-slate-400">{{ c.name }}</span>
                </div>
            </div>
        </section>

        <section v-if="testimonials.length" class="bg-brand-900 py-24 text-white">
            <div class="container-x">
                <h2 class="text-center text-3xl font-extrabold tracking-tight sm:text-4xl">What our clients say</h2>
                <div class="mt-14 grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div v-for="t in testimonials" :key="t.id" class="rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur">
                        <p class="text-lg leading-relaxed text-slate-200">"{{ t.message }}"</p>
                        <p class="mt-6 font-semibold">{{ t.name }}</p>
                        <p class="text-sm text-slate-400">{{ t.designation }}<span v-if="t.company"> · {{ t.company }}</span></p>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
