<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PageForm from '@/Pages/Admin/Content/PageForm.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    groups: Array,
    values: Object,
    active: String,
});

const group = computed(() => props.groups.find((g) => g.page === props.active));
const open = (page) => router.get(route('admin.content.edit'), { page }, { preserveScroll: true });
</script>

<template>
    <Head title="Page content" />

    <AdminLayout title="Page content">
        <p class="mb-4 text-sm text-slate-500">
            Edit the text, links, cards and pictures shown on each page of the website. Leave a field untouched to keep the current content.
        </p>

        <div class="-mx-1 mb-5 flex gap-1 overflow-x-auto px-1 pb-1">
            <button
                v-for="g in groups"
                :key="g.page"
                type="button"
                class="shrink-0 rounded-md border px-4 py-2 text-sm font-medium transition"
                :class="g.page === active ? 'border-accent-500 bg-accent-500 text-white shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
                @click="open(g.page)"
            >
                {{ g.page }}
            </button>
        </div>

        <PageForm v-if="group" :key="group.page" :group="group" :values="values" />
    </AdminLayout>
</template>
