<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import { safeRoute } from '@/Components/Admin/Dashboard/helpers';
import Icon from '@/Components/Icon.vue';
import { Link } from '@inertiajs/vue3';

const actions = [
    { label: 'New package', hint: 'Plans & pricing', icon: 'cube', route: 'admin.packages.index', chip: 'from-sky-500 to-blue-600' },
    { label: 'New blog post', hint: 'Write an article', icon: 'newspaper', route: 'admin.blog-posts.index', chip: 'from-emerald-500 to-teal-500' },
    { label: 'Edit page content', hint: 'Texts & pictures', icon: 'document-text', route: 'admin.content.edit', chip: 'from-violet-500 to-fuchsia-500' },
    { label: 'Add testimonial', hint: 'Customer reviews', icon: 'chat-bubble-left-right', route: 'admin.testimonials.index', chip: 'from-amber-400 to-orange-500' },
    { label: 'Manage sliders', hint: 'Homepage banners', icon: 'photo', route: 'admin.sliders.index', chip: 'from-rose-500 to-pink-600' },
    { label: 'Settings', hint: 'Contact, logo, map', icon: 'cog', route: 'admin.settings.edit', chip: 'from-slate-600 to-slate-800' },
];
</script>

<template>
    <AdminCard title="Quick actions" accent="accent">
        <div class="grid grid-cols-2 gap-3 p-4 sm:grid-cols-3 sm:p-5 xl:grid-cols-6">
            <Link
                v-for="a in actions"
                :key="a.label"
                :href="safeRoute(a.route)"
                class="group flex min-h-[44px] flex-col items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/60 p-3.5 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-lg"
            >
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br text-white shadow-md transition group-hover:scale-110 group-hover:rotate-3" :class="a.chip"><Icon :name="a.icon" class="h-5 w-5" /></span>
                <span>
                    <span class="block text-sm font-semibold text-slate-700">{{ a.label }}</span>
                    <span class="block text-xs text-slate-400">{{ a.hint }}</span>
                </span>
            </Link>
        </div>
    </AdminCard>
</template>
