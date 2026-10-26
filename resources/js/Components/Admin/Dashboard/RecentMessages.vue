<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import { avatarGradient, formatDate, initials, safeRoute } from '@/Components/Admin/Dashboard/helpers';
import Icon from '@/Components/Icon.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    messages: { type: Array, default: () => [] },
});

const typePill = {
    quote: 'bg-amber-50 text-amber-700 ring-amber-200',
    package: 'bg-violet-50 text-violet-700 ring-violet-200',
    general: 'bg-sky-50 text-sky-700 ring-sky-200',
};
const typeLabel = { quote: 'Quote', package: 'Package', general: 'General' };
</script>

<template>
    <AdminCard title="Recent messages" accent="brand">
        <template #tools>
            <Link :href="safeRoute('admin.contact-messages.index')" class="inline-flex min-h-[32px] items-center text-xs font-semibold text-brand-600 hover:underline">View all →</Link>
        </template>

        <ul v-if="messages.length" class="divide-y divide-slate-100">
            <li v-for="m in messages" :key="m.id">
                <Link :href="safeRoute('admin.contact-messages.index')" class="flex items-start gap-3 px-4 py-3 transition hover:bg-slate-50 sm:px-5" :aria-label="`Message from ${m.name}`">
                    <span class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br text-sm font-bold text-white" :class="avatarGradient(m.email || m.name)">
                        {{ initials(m.name) }}
                        <span v-if="!m.is_read" class="absolute -right-0.5 -top-0.5 h-3 w-3 rounded-full border-2 border-white bg-rose-500" title="Unread" />
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="flex flex-wrap items-center gap-x-2 gap-y-1">
                            <span class="truncate text-sm" :class="m.is_read ? 'font-medium text-slate-700' : 'font-bold text-slate-900'">{{ m.name }}</span>
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide ring-1" :class="typePill[m.type] ?? typePill.general">{{ typeLabel[m.type] ?? m.type ?? 'General' }}</span>
                            <span v-if="m.package_name" class="inline-flex items-center gap-1 text-[11px] text-slate-400"><Icon name="cube" class="h-3 w-3" />{{ m.package_name }}</span>
                        </span>
                        <span class="mt-0.5 line-clamp-1 block text-sm text-slate-500">{{ m.subject || m.message }}</span>
                        <span class="mt-0.5 block truncate text-xs text-slate-400">{{ m.email }}<span v-if="m.phone"> · {{ m.phone }}</span></span>
                    </span>
                    <span class="shrink-0 whitespace-nowrap pt-0.5 text-xs text-slate-400">{{ m.time_ago || formatDate(m.created_at) }}</span>
                </Link>
            </li>
        </ul>

        <div v-else class="flex flex-col items-center px-4 py-10 text-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400"><Icon name="envelope" class="h-7 w-7" /></span>
            <p class="mt-3 text-sm font-medium text-slate-600">No messages yet</p>
            <p class="mt-1 text-xs text-slate-400">Messages from the Contact form will show up here.</p>
        </div>
    </AdminCard>
</template>
