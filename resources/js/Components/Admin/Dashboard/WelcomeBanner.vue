<script setup>
import { safeRoute } from '@/Components/Admin/Dashboard/helpers';
import Icon from '@/Components/Icon.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    unread: { type: Number, default: 0 },
    today: { type: Number, default: 0 },
    week: { type: Number, default: 0 },
    siteUrl: { type: String, default: '' },
});

const user = computed(() => usePage().props.auth?.user);
const firstName = computed(() => (user.value?.name || 'Admin').split(' ')[0]);

const now = new Date();
const greeting = now.getHours() < 12 ? 'Good morning' : now.getHours() < 17 ? 'Good afternoon' : 'Good evening';
const dateText = now.toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

const websiteUrl = computed(() => props.siteUrl || safeRoute('home', '/'));
</script>

<template>
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#1a2233] via-brand-800 to-brand-600 p-6 text-white shadow-lg sm:p-8">
        <div class="grid-bg absolute inset-0 opacity-40 [mask-image:radial-gradient(ellipse_at_top_right,black,transparent_70%)]" />
        <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full bg-accent-400/30 blur-3xl" />
        <div class="pointer-events-none absolute -bottom-24 left-10 h-56 w-56 rounded-full bg-brand-400/25 blur-3xl" />
        <Icon name="sparkles" class="pointer-events-none absolute -bottom-6 right-6 hidden h-40 w-40 rotate-12 text-white/10 md:block" />

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="min-w-0">
                <p class="flex items-center gap-2 text-sm text-brand-200">
                    <Icon name="calendar" class="h-4 w-4" />
                    {{ dateText }}
                </p>
                <h2 class="mt-2 text-2xl font-extrabold tracking-tight sm:text-3xl">{{ greeting }}, {{ firstName }} <span aria-hidden="true">👋</span></h2>
                <p class="mt-2 max-w-xl text-sm text-brand-100 sm:text-base">
                    <template v-if="unread > 0">
                        You have <strong class="text-white">{{ unread }} unread {{ unread === 1 ? 'message' : 'messages' }}</strong> waiting for a reply.
                    </template>
                    <template v-else>You're all caught up — no unread messages.</template>
                    <span v-if="today || week" class="text-brand-200"> {{ today }} new today, {{ week }} this week.</span>
                </p>

                <div class="mt-5 flex flex-wrap gap-3">
                    <a
                        :href="websiteUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex min-h-[44px] items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-brand-900 shadow transition hover:bg-brand-50"
                    >
                        <Icon name="globe" class="h-5 w-5" />
                        View website
                    </a>
                    <Link
                        :href="safeRoute('admin.content.edit')"
                        class="inline-flex min-h-[44px] items-center gap-2 rounded-lg border border-white/30 bg-white/10 px-4 py-2 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20"
                    >
                        <Icon name="document-text" class="h-5 w-5" />
                        Page content
                    </Link>
                </div>
            </div>

            <Link
                :href="safeRoute('admin.contact-messages.index')"
                class="group relative flex shrink-0 items-center gap-4 self-start rounded-2xl border border-white/20 bg-white/10 p-4 backdrop-blur transition hover:bg-white/15 lg:self-auto"
                :aria-label="`${unread} unread messages`"
            >
                <span class="relative flex h-14 w-14 items-center justify-center rounded-xl bg-white/15">
                    <Icon name="envelope" class="h-7 w-7" />
                    <span v-if="unread > 0" class="absolute -right-1 -top-1 flex h-4 w-4"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-rose-400 opacity-75" /><span class="relative inline-flex h-4 w-4 rounded-full bg-rose-500" /></span>
                </span>
                <span>
                    <span class="block text-3xl font-extrabold leading-none">{{ unread }}</span>
                    <span class="mt-1 block text-xs font-medium uppercase tracking-wider text-brand-200">Unread messages</span>
                </span>
            </Link>
        </div>
    </section>
</template>
