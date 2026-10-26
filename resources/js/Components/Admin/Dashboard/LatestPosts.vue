<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import { formatDate, safeRoute } from '@/Components/Admin/Dashboard/helpers';
import Icon from '@/Components/Icon.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    posts: { type: Array, default: () => [] },
});
</script>

<template>
    <AdminCard title="Latest blog posts" accent="emerald">
        <template #tools>
            <Link :href="safeRoute('admin.blog-posts.index')" class="inline-flex min-h-[32px] items-center text-xs font-semibold text-brand-600 hover:underline">Manage →</Link>
        </template>

        <ul v-if="posts.length" class="divide-y divide-slate-100">
            <li v-for="p in posts" :key="p.id">
                <Link :href="safeRoute('admin.blog-posts.index')" class="flex items-center gap-3 px-4 py-3 transition hover:bg-slate-50 sm:px-5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600"><Icon name="newspaper" class="h-5 w-5" /></span>
                    <span class="min-w-0 flex-1">
                        <span class="line-clamp-1 block text-sm font-medium text-slate-700">{{ p.title }}</span>
                        <span class="mt-0.5 block text-xs text-slate-400">{{ formatDate(p.published_at || p.created_at) }}</span>
                    </span>
                    <span
                        class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide ring-1"
                        :class="p.is_published ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-slate-100 text-slate-500 ring-slate-200'"
                    >
                        {{ p.is_published ? 'Published' : 'Draft' }}
                    </span>
                </Link>
            </li>
        </ul>

        <div v-else class="flex flex-col items-center px-4 py-10 text-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400"><Icon name="newspaper" class="h-7 w-7" /></span>
            <p class="mt-3 text-sm font-medium text-slate-600">No blog posts yet</p>
            <Link :href="safeRoute('admin.blog-posts.index')" class="mt-2 text-xs font-semibold text-brand-600 hover:underline">Write the first one →</Link>
        </div>
    </AdminCard>
</template>
