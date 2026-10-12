<script setup>
import FlashToast from '@/Components/FlashToast.vue';
import Icon from '@/Components/Icon.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

defineProps({
    title: { type: String, default: '' },
});

const page = usePage();
const user = computed(() => page.props.auth?.user);
const sidebarOpen = ref(false);
const userMenuOpen = ref(false);

const initials = computed(() =>
    (user.value?.name || 'A')
        .split(' ')
        .map((w) => w[0])
        .slice(0, 2)
        .join('')
        .toUpperCase(),
);

const navGroups = [
    {
        label: 'Main',
        items: [{ label: 'Dashboard', icon: 'squares', href: () => route('admin.dashboard'), match: 'admin.dashboard' }],
    },
    {
        label: 'Content Management',
        items: [
            { label: 'Sliders', icon: 'photo', href: () => route('admin.sliders.index'), match: 'admin.sliders.*' },
            { label: 'Packages', icon: 'cube', href: () => route('admin.packages.index'), match: 'admin.packages.*' },
            { label: 'Services', icon: 'wrench', href: () => route('admin.services.index'), match: 'admin.services.*' },
            { label: 'Blog posts', icon: 'newspaper', href: () => route('admin.blog-posts.index'), match: 'admin.blog-posts.*' },
            { label: 'Testimonials', icon: 'chat-bubble-left-right', href: () => route('admin.testimonials.index'), match: 'admin.testimonials.*' },
            { label: 'Clients / Partners', icon: 'user-group', href: () => route('admin.partners.index'), match: 'admin.partners.*' },
            { label: 'Coverage areas', icon: 'map-pin', href: () => route('admin.coverage-areas.index'), match: 'admin.coverage-areas.*' },
            { label: 'FAQ', icon: 'question-mark-circle', href: () => route('admin.faqs.index'), match: 'admin.faqs.*' },
            { label: 'Stats counter', icon: 'chart-bar', href: () => route('admin.stats.index'), match: 'admin.stats.*' },
        ],
    },
    {
        label: 'System',
        items: [
            { label: 'Contact messages', icon: 'envelope', href: () => route('admin.contact-messages.index'), match: 'admin.contact-messages.*' },
            { label: 'Settings', icon: 'cog', href: () => route('admin.settings.edit'), match: 'admin.settings.*' },
        ],
    },
];
</script>

<template>
    <div class="flex min-h-screen bg-[#f4f6f9]">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 flex w-60 -translate-x-full transform flex-col bg-[#1a2233] transition-transform lg:static lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen }"
        >
            <Link :href="route('admin.dashboard')" class="flex h-16 shrink-0 items-center gap-2 border-b border-white/10 px-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-accent-500 text-sm font-bold text-white">E</span>
                <span class="text-sm font-bold tracking-wide text-white">EASYLINK <span class="block text-[10px] font-normal text-slate-400">ADMIN PANEL</span></span>
            </Link>

            <div class="flex items-center gap-3 border-b border-white/10 px-4 py-4">
                <span class="relative flex h-9 w-9 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white">
                    {{ initials }}
                    <span class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full border-2 border-[#1a2233] bg-emerald-400" />
                </span>
                <div>
                    <p class="text-sm font-semibold text-white">{{ user?.name }}</p>
                    <p class="text-xs text-emerald-400">Online</p>
                </div>
            </div>

            <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-4">
                <div v-for="group in navGroups" :key="group.label">
                    <p class="px-3 pb-1.5 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ group.label }}</p>
                    <div class="space-y-0.5">
                        <Link
                            v-for="item in group.items"
                            :key="item.match"
                            :href="item.href()"
                            class="flex items-center gap-3 rounded-md border-l-[3px] px-3 py-2 text-sm font-medium transition"
                            :class="
                                route().current(item.match)
                                    ? 'border-accent-500 bg-white/10 text-white'
                                    : 'border-transparent text-slate-300 hover:border-slate-500 hover:bg-white/5 hover:text-white'
                            "
                            @click="sidebarOpen = false"
                        >
                            <Icon :name="item.icon" class="h-5 w-5 shrink-0" />
                            {{ item.label }}
                        </Link>
                    </div>
                </div>
            </nav>
        </aside>

        <div v-if="sidebarOpen" class="fixed inset-0 z-30 bg-black/40 lg:hidden" @click="sidebarOpen = false" />

        <div class="flex min-h-screen flex-1 flex-col">
            <!-- Topbar -->
            <header class="sticky top-0 z-20 flex h-14 items-center justify-between border-b border-slate-200 bg-white px-4 shadow-sm sm:px-6">
                <div class="flex items-center gap-4">
                    <button class="text-slate-500 hover:text-slate-700" @click="sidebarOpen = true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <Link :href="route('home')" class="hidden text-sm text-slate-500 hover:text-brand-700 sm:block">← View website</Link>
                </div>

                <div class="relative">
                    <button class="flex items-center gap-2 rounded-md px-2 py-1.5 hover:bg-slate-100" @click="userMenuOpen = !userMenuOpen">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white">{{ initials }}</span>
                        <span class="hidden text-sm font-medium text-slate-700 sm:block">{{ user?.name }}</span>
                    </button>

                    <div v-if="userMenuOpen" class="absolute right-0 z-30 mt-2 w-48 rounded-md border border-slate-200 bg-white py-1 shadow-lg" @click="userMenuOpen = false">
                        <Link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">Profile</Link>
                        <Link :href="route('logout')" method="post" as="button" class="block w-full px-4 py-2 text-left text-sm text-rose-600 hover:bg-slate-50">Logout</Link>
                    </div>
                </div>
            </header>

            <!-- Content header -->
            <div v-if="title || $slots.header" class="border-b border-slate-200 bg-white px-4 py-4 sm:px-6">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h1 class="text-lg font-semibold text-slate-800">
                        <slot name="header">{{ title }}</slot>
                    </h1>
                    <p class="text-xs text-slate-400">
                        <Link :href="route('admin.dashboard')" class="hover:text-brand-600">Home</Link>
                        <span class="mx-1">/</span>
                        <span class="text-slate-500">{{ title }}</span>
                    </p>
                </div>
            </div>

            <main class="flex-1 p-4 sm:p-6">
                <slot />
            </main>
        </div>

        <FlashToast />
    </div>
</template>
