<script setup>
import AdminCard from '@/Components/Admin/AdminCard.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    messages: Object,
});

const expanded = ref(null);

const markRead = (message) => {
    router.patch(route('admin.contact-messages.update', message.id), {}, { preserveScroll: true });
};

const destroy = (message) => {
    if (confirm(`"${message.name}" Delete the message from this sender?`)) {
        router.delete(route('admin.contact-messages.destroy', message.id), { preserveScroll: true });
    }
};

const typeLabel = { general: 'General', quote: 'Quote', package: 'Packages' };
</script>

<template>
    <Head title="Contact messages" />

    <AdminLayout title="Contact messages">
        <AdminCard title="All messages">
        <div class="divide-y divide-slate-100">
            <div
                v-for="message in messages.data"
                :key="message.id"
                class="p-4"
                :class="{ 'border-l-[3px] border-accent-500 bg-accent-50/30': !message.is_read }"
            >
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div class="cursor-pointer" @click="expanded = expanded === message.id ? null : message.id">
                        <p class="font-semibold text-slate-700">
                            {{ message.name }}
                            <span class="ml-2 rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-500">{{ typeLabel[message.type] }}</span>
                            <span v-if="message.package" class="ml-1 rounded-full bg-brand-50 px-2 py-0.5 text-xs text-brand-700">{{ message.package.name }}</span>
                        </p>
                        <p class="text-sm text-slate-500">{{ message.email }} · {{ message.phone }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ message.subject }}</p>
                        <p v-if="expanded === message.id" class="mt-2 whitespace-pre-line rounded-lg bg-slate-50 p-3 text-sm text-slate-600">{{ message.message }}</p>
                    </div>
                    <div class="flex shrink-0 gap-3 text-sm">
                        <button v-if="!message.is_read" class="text-brand-600 hover:underline" @click="markRead(message)">Mark as read</button>
                        <button class="text-rose-600 hover:underline" @click="destroy(message)">Delete</button>
                    </div>
                </div>
            </div>
            <p v-if="!messages.data.length" class="p-8 text-center text-slate-400">No messages yet.</p>
        </div>
        </AdminCard>

        <div v-if="messages.links?.length > 3" class="mt-8 flex flex-wrap gap-2">
            <Link
                v-for="(link, i) in messages.links"
                :key="i"
                :href="link.url || '#'"
                v-html="link.label"
                class="rounded-lg px-3 py-1.5 text-sm"
                :class="link.active ? 'bg-brand-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-100'"
            />
        </div>
    </AdminLayout>
</template>
