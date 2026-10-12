<script setup>
import Icon from '@/Components/Icon.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings ?? {});
const user = computed(() => page.props.auth?.user);

const mobileOpen = ref(false);

const nav = [
    { label: 'Home', href: route('home') },
    { label: 'Packages', href: route('packages.index') },
    { label: 'Corporate', href: route('corporate') },
    { label: 'Services', href: route('services.index') },
    { label: 'Coverage', href: route('coverage.index') },
    { label: 'Blog', href: route('blog.index') },
    { label: 'About', href: route('about') },
    { label: 'Contact', href: route('contact.index') },
];

const isActive = (href) => page.url === new URL(href, window.location.origin).pathname;
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/85 backdrop-blur-lg">
        <div class="bg-brand-900 text-slate-300">
            <div class="container-x flex h-9 items-center justify-between text-xs">
                <div class="hidden items-center gap-5 sm:flex">
                    <a :href="`mailto:${settings.email}`" class="flex items-center gap-1.5 hover:text-white">
                        <Icon name="envelope" class="h-3.5 w-3.5" />
                        {{ settings.email }}
                    </a>
                    <span class="flex items-center gap-1.5">
                        <Icon name="map-pin" class="h-3.5 w-3.5" />
                        {{ settings.address }}
                    </span>
                </div>
                <div class="flex w-full items-center justify-between gap-4 sm:w-auto sm:justify-end">
                    <a :href="`tel:${settings.hotline}`" class="flex items-center gap-1.5 font-semibold text-brand-300">
                        <Icon name="phone" class="h-3.5 w-3.5" />
                        Hotline: {{ settings.hotline }}
                    </a>
                    <Link v-if="user" :href="route('admin.dashboard')" class="hover:text-white">Admin Panel</Link>
                    <Link v-else :href="route('login')" class="hover:text-white">Self-Care Login</Link>
                </div>
            </div>
        </div>

        <div class="container-x flex h-[72px] items-center justify-between">
            <Link :href="route('home')" class="flex items-center gap-2.5">
                <img :src="settings.logo || '/images/logo-mark.png'" alt="EasyLink logo" class="h-12 w-12 object-contain" />
                <span class="font-display text-xl font-extrabold tracking-tight text-brand-900">{{ settings.site_name || 'EasyLink' }}</span>
            </Link>

            <nav class="hidden items-center gap-0.5 lg:flex">
                <Link
                    v-for="item in nav"
                    :key="item.href"
                    :href="item.href"
                    class="rounded-full px-3.5 py-2 text-sm font-medium transition"
                    :class="isActive(item.href) ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-100 hover:text-brand-900'"
                >
                    {{ item.label }}
                </Link>
            </nav>

            <div class="hidden lg:flex">
                <Link :href="route('contact.index')" class="btn-primary !py-2.5">Get a quote</Link>
            </div>

            <button class="rounded-lg p-1 lg:hidden" aria-label="Toggle menu" @click="mobileOpen = !mobileOpen">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-brand-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path v-if="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div v-if="mobileOpen" class="border-t border-slate-100 bg-white lg:hidden">
            <nav class="container-x flex flex-col py-3">
                <Link
                    v-for="item in nav"
                    :key="item.href"
                    :href="item.href"
                    class="rounded-xl px-3 py-2.5 text-sm font-medium"
                    :class="isActive(item.href) ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50'"
                    @click="mobileOpen = false"
                >
                    {{ item.label }}
                </Link>
                <Link :href="route('contact.index')" class="btn-primary mt-3" @click="mobileOpen = false">Get a quote</Link>
            </nav>
        </div>
    </header>
</template>
