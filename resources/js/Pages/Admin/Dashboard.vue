<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import SmallBox from '@/Components/Admin/SmallBox.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    counts: Object,
    recentMessages: Array,
});

const boxes = [
    { key: 'packages', label: 'Total packages', icon: 'cube', color: 'info', href: () => route('admin.packages.index') },
    { key: 'services', label: 'Total services', icon: 'wrench', color: 'success', href: () => route('admin.services.index') },
    { key: 'blogPosts', label: 'Blog posts', icon: 'newspaper', color: 'warning', href: () => route('admin.blog-posts.index') },
    { key: 'unreadMessages', label: 'Unread messages', icon: 'envelope', color: 'danger', href: () => route('admin.contact-messages.index') },
];
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout title="Dashboard">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <SmallBox v-for="box in boxes" :key="box.key" :value="props.counts[box.key]" :label="box.label" :icon="box.icon" :color="box.color" :href="box.href()" />
        </div>

        <AdminCard title="Recent messages" class="mt-6">
            <template #tools>
                <Link :href="route('admin.contact-messages.index')" class="text-xs font-medium text-brand-600 hover:underline">View all</Link>
            </template>
            <div class="divide-y divide-slate-100 px-4">
                <div v-for="m in recentMessages" :key="m.id" class="py-3">
                    <p class="text-sm font-medium text-slate-700">{{ m.name }} <span class="text-slate-400">· {{ m.email }}</span></p>
                    <p class="mt-1 line-clamp-1 text-sm text-slate-500">{{ m.subject || m.message }}</p>
                </div>
                <p v-if="!recentMessages.length" class="py-6 text-center text-sm text-slate-400">No messages yet.</p>
            </div>
        </AdminCard>
    </AdminLayout>
</template>
